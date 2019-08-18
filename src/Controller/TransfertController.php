<?php

namespace App\Controller;

use App\Form\ExpType;
use App\Form\TransType;
use App\Entity\Expediteur;
use App\Entity\Transaction;
use App\Entity\Beneficiaire;
use App\Repository\TarifsRepository;
use App\Repository\ExpediteurRepository;
use App\Repository\TransactionRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 *@Route("/api")
 */
class TransfertController extends FOSRestController
{
    private $envoye = 'Envoyé';
    private $retire = 'Retiré';

    /**
     * @Rest\Post(
     *  path="/envoi",
     *  name="envoi"
     * )
     * @ParamConverter("benef", converter="fos_rest.request_body")
     * @ParamConverter("exp", converter="fos_rest.request_body")
     * @ParamConverter("envoie", converter="fos_rest.request_body")
     */
    public function envoie(Expediteur $exp,Beneficiaire $benef, Transaction $envoie, Request $request, ObjectManager $manager,TarifsRepository $trepo,ValidatorInterface $validator)
    {
        $form = $this->createForm(TransType::class, $envoie);
        $data=$request->request->all();
        $cmpt = $this->getUser()->getCompte();

        $envoie->setCreatedAt(new \DateTime('now'));
        $errors = $validator->validate($envoie);
        if(count($errors))
        {
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $form->submit($data);
        $form->handleRequest($request);

            $montant = $envoie->getMontantTransfert();
            $cmptvalid = $cmpt->getMontant();
            
            if($montant > $cmptvalid)
            {
                throw new HttpException(403,'Le solde de votre compte ne vous permet pas de traiter cette transaction !');
            }
           
            $tarif = $trepo->findAll();

            foreach($tarif as  $val)
            {
                $borninf = $val->getBorneInferieure();
                $bornsup = $val->getBorneSuperieure();
                
                if($borninf <= $montant && $montant <= $bornsup)
                {
                    $valeur  = $val->getValeur();
                }
                         
            }
        
        $comEtat    = $valeur * 0.3; $envoie->setCommissionEtat($comEtat);
        $comSyst    = $valeur * 0.4; $envoie->setCommissionSysteme($comSyst);
        $comEnvoie  = $valeur * 0.1; $envoie->setCommissionEnvoie($comEnvoie);
        $comRetrait = $valeur * 0.2; $envoie->setCommissionRetrait($comRetrait);
            $envoie->setFraisTransaction($valeur);
            $codegen=date('i').date('H').date('d').date('m').date('Y');
            $envoie->setCodeGenere($codegen);
            $envoie->setTotalEnvoi($envoie->getFraisTransaction() + $montant);          
            $cmpt->setMontant($cmptvalid - $montant + $comEnvoie);
            $envoie->setStatut($this->envoye); 
            
            $envoie->setBeneficiaire($benef);
            $envoie->setExpediteur($exp);
            $envoie->setCompteEnv($cmpt);       
           
            $manager->persist($exp);
            $manager->persist($benef);
            $manager->persist($envoie);
            $manager->flush();

            return  $this->handleView($this->view('Envoie réussi', Response::HTTP_CREATED));
    }

    /**
     * @Rest\Get(
     *  path = "/retrait/{codesearch}",
     *  name = "retrait"
     * )
     */
    public function retrait(TransactionRepository $exp,$codesearch,ValidatorInterface $validator,ObjectManager $manager)
    {
        $cmpt = $this->getUser()->getCompte();
        
        $trans = $exp->findOneBy(['codeGenere' => $codesearch]);
        $codegen = $trans->getCodeGenere();
        $statut  = $trans->getStatut();
        $comRetrait = $trans->getCommissionRetrait();
        $montantCmpt = $cmpt->getMontant();
        $montantTrans = $trans->getMontantTransfert();
        
        if(!$trans)
        {
            throw new HttpException(403,'Ce code n\'existe pas !');
        }
        elseif($codegen == $codesearch && $statut == $this->retire)
        {
            return  $this->handleView($this->view('Ce code a été déjà utilisé', Response::HTTP_CREATED));
        }
        else
        {
            $trans->setCompteRet($cmpt);
            $trans->setStatut($this->retire);
            $trans->setDateRetrait(new \DateTime('now'));
            $cmpt->setMontant($montantCmpt + $comRetrait + $montantTrans);
            $manager->flush();
        }
        
        return  $this->handleView($this->view('Retrait effectué avec succés', Response::HTTP_CREATED));
    }

    /**
     * @Rest\Get(
     *  path = "/attcmpt",
     *  name = "attcompt"
     * )
     */
    public function attcmpt(UtilisateurRepository $user)
    {  
        $cmpt = $this->getUser()->getCompte();
        var_dump($cmpt);die();
    }
}
