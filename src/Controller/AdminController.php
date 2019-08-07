<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Partenaire;
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
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Vous n\'avez accés aux ajout de partenaire');
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
     * @Rest\Post(
     *    path = "/adduser",
     *    name = "app_user_admin_create"
     * )
     *  @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function addUser(Request $request,Utilisateur $user,ConstraintViolationList $violations, UserPasswordEncoderInterface $passwordEncoder,ValidatorInterface $validator)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN_PARTENAIRE', null, 'Vous n\'avez accés aux ajout d\'utilisateur partenaire');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setStatut("Actif");
    
        $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
        
        if (count($violations))
        {
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }
        $errors = $validator->validate($user);
        
        if(count($errors))
        {
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $part= $this->getUser()->getPartenaire();
        
        if($part)
        {
            $user->setPartenaire($part);
        }
        else{
            $user->setPartenaire(null);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->view('Utilisateur ajouté', Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
      
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
        if (count($violations))
        {
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }

        $parte->setStatut($newparte->getStatut());
        $em = $this->getDoctrine()->getManager();
        $em->flush();
     
        return  $this->handleView($this->view('Statut changé', Response::HTTP_CREATED));
    }

}
