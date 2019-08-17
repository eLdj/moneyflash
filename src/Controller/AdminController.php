<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Partenaire;
use Twig\Profiler\Profile;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class AdminController extends FOSRestController
{ 
         
    /**
     * @Rest\Post(
     *      path = "/compte/{id}",
     *      name = "new_compte"
     * )
     * @ParamConverter("cmpt", converter="fos_rest.request_body")
     */
    public function addCompte(Compte $cmpt,Partenaire $part,ValidatorInterface $validator)
    {
       # $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Vous n\'avez accés aux ajout de partenaire');
        $errors = $validator->validate($cmpt);
        if(count($errors))
        {
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        
        $cmpt->setPartenaire($part);
       
        $num = random_int(100000, 999999);
        $cmpt->setNumero($part->getId()+$cmpt->getId()+$num);
        $cmpt->setDateDepot(new \DateTime());
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($cmpt);
        $em->flush();

        return  $this->handleView($this->view('Compte ajouté avec succés', Response::HTTP_CREATED));
    }
    
  
    /**
     * @Rest\View(StatusCode = 200)
     * @Rest\Put(
     *      path = "/depot/{id}",
     *      name = "depot",
     * )
     * @ParamConverter("dpt", converter="fos_rest.request_body")
     */
    public function depot(Depot $dpt,Compte $cpt,ValidatorInterface $validator)
    {   
        #$this->denyAccessUnlessGranted('ROLE_CAISSIER', null, 'Vous n\'avez accés aux dépot');
        $errors = $validator->validate($dpt);
        if(count($errors))
        {
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
            $user = $this->getUser();
            $dpt->setCaissier($user);
            $dpt->setCompte($cpt);
            $cpt->setDateDepot(new \DateTime());
            $dpt->setDateDepot(new \DateTime());
            $cpt->setMontant($cpt->getMontant()+$dpt->getMontantDepot());

        $em = $this->getDoctrine()->getManager();
        $em->persist($dpt);
        $em->flush();

        return $this->handleView($this->view("Depot effectué avec succés", Response::HTTP_CREATED));
    }

    /** 
    * @Rest\View(StatusCode = 200)
    * @Rest\Put(
    *    path = "/statut/{id}",
    *    name = "app_part_modif"
    * )
    * @ParamConverter("newparte", converter="fos_rest.request_body")
    */
    public function editpart(Utilisateur $parte,Utilisateur $newparte, ConstraintViolationList $violations)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Vous n\'avez pas accés aux Blocage d\'utilisateur');
        if (count($violations))
        {
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }

        $parte->setStatut($newparte->getStatut());
        $em = $this->getDoctrine()->getManager();
        $em->flush();
     
        return  $this->handleView($this->view('Statut changé', Response::HTTP_CREATED));
    }

    // /**
    //  * @Rest\Post(
    //  *      path="/profil",
    //  *      name="profil"
    //  * )
    //  */
    // public function addProfil(Request $request)
    // {
    //     $profil= new Profil();
    //     $form=$this->createForm(ProfilType::class,$profil);
    //     $data=json_decode($request->getContent(),true);
    //     $form->submit($data);
        
    //     if($form->isSubmitted() && $form->isValid()){
    //         $em=$this->getDoctrine()->getManager();
    //         $em->persist($profil);
    //         $em->flush();
    //         return $this->handleView($this->view(['status'=>'ok'],Response::HTTP_CREATED));
    //     }
    //     return $this->handleView($this->view($form->getErrors()));
    // }

}
