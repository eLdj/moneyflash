<?php

namespace App\Controller;


use App\Form\BenefType;
use App\Form\TransType;

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
use Symfony\Component\Serializer\SerializerInterface;


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
     * @ParamConverter("envoie", converter="fos_rest.request_body")
     */
    public function envoie(Transaction $envoie, Request $request, ObjectManager $manager,TarifsRepository $trepo,ValidatorInterface $validator,SerializerInterface $serializer)
    {
        
        $cmpt = $this->getUser()->getCompte();

        $envoie->setCreatedAt(new \DateTime('now'));
        $errors = $validator->validate($envoie);
        if(count($errors))
        {
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
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
            $envoie->setCompteEnv($cmpt);       
           
            $manager->persist($envoie);
            $manager->flush();

            $data = $serializer->serialize($envoie, 'json', [
                'groups' => ['envoie']
            ]);

            return new Response($data, 200, [
                'Content-Type' => 'application/json'
            ]);
    
    }

    public function codeSearch(TransactionRepository $trans,$code)
    {
        
        $codesearch = $trans->findOneBy(['codeGenere' => $code]);

        if(!$codesearch)
        {
            throw new HttpException(403,'Ce code n\'existe pas !');
        }
        elseif($codesearch->getStatut()==$this->retire)
        {
           // return  $this->handleView($this->view('Ce code a été déjà utilisé', Response::HTTP_CREATED));
           throw new HttpException(406,'Ce code a été déjà utilisé');
        
        }

        return  $codesearch;
    }

    /**
     * @Rest\Post(
     *  path="/findcode",
     *  name="findcode"
     * )
     */
    public function findCode(Request $request,TransactionRepository $trans,SerializerInterface $serializer){

        $data = json_decode($request->getContent(),true);
            
        if(!$data){

            $data=$request->request->all();
        }

        $code = $data['code_genere'];

        $cocefind = $this->codeSearch($trans,$code);

        $data = $serializer->serialize($cocefind, 'json',[
            'groups' => ['envoie']
        ]);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
    
    /**
     * @Rest\Post(
     *  path = "/retrait",
     *  name = "retrait"
     * )
     *  @Rest\View(statusCode = 201)
     */
    public function retrait(Request $request,TransactionRepository $exp,ValidatorInterface $validator,ObjectManager $manager,SerializerInterface $serializer)
    {
        $cmpt = $this->getUser()->getCompte();

    $data = json_decode($request->getContent(),true);
        
        if(!$data){

            $data=$request->request->all();
        }

        $code = $data['code_genere'];
        
        $trans =$this->codeSearch($exp,$code);
    
        $comRetrait = $trans->getCommissionRetrait();

        $montantCmpt = $cmpt->getMontant();
        $montantTrans = $trans->getMontantTransfert();

            $trans->setCinB($data['cin_b']);
            $trans->setCompteRet($cmpt);
            $trans->setStatut($this->retire);
            $trans->setDateRetrait(new \DateTime('now'));
            $cmpt->setMontant($montantCmpt + $comRetrait + $montantTrans);
            $manager->flush();

            $donne = $serializer->serialize($trans, 'json',[
                'groups' => ['retrait']
            ]);

            return new Response($donne, 200, [
                'Content-Type' => 'application/json'
            ]);
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
