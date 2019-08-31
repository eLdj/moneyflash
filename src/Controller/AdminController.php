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
     * @Rest\View(StatusCode = 200)
     * @Rest\Put(
     *      path = "/depot/{id}",
     *      name = "depot",
     * )
     * @ParamConverter("dpt", converter="fos_rest.request_body")
     */
    public function depot(Depot $dpt,Compte $cpt,ValidatorInterface $validator)
    {   
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
