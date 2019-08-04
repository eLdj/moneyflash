<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Compte;
use App\Form\PartType;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Repository\PartenaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UserType;
use App\Form\CompteType;

/**
 * @Route("/api")
 */
class AdminController extends FOSRestController
{   

    /**
     * @Rest\Post(
     *    path = "/part",
     *    name = "app_part_create"
     * )
     * @ParamConverter("part", converter="fos_rest.request_body")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @ParamConverter("cmpt", converter="fos_rest.request_body")
     */
    public function createPart(Request $request,Partenaire $part,Utilisateur $user,Compte $cmpt, ConstraintViolationList $violations, UserPasswordEncoderInterface $passwordEncoder)
    {
        $values = json_decode($request->getContent(), true);
        
        $form = $this->createForm(UserType::class, $user);
        $form1 = $this->createForm(CompteType::class, $cmpt);
        $form->handleRequest($request);
        $form1->handleRequest($request);

        $form->submit($values);
        $form1->submit($values);
        if (count($violations)) 
        {
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }
        
   

        $part->setCreatedAt(new \DateTime());
        $cmpt->setDateDepot(new \DateTime());
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
        $user->setPartenaire($part);
        $cmpt->setPartenaire($part);
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($cmpt);
        $em->persist($user);
        $em->persist($part);
        $em->flush();
         return  $this->handleView($this->view($part, Response::HTTP_CREATED));
       
    }
    
    /**
     * @Rest\Post(
     *    path = "/user",
     *    name = "app_user_create"
     * )
     *  @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function addUser(Request $request,Utilisateur $user,ConstraintViolationList $violations, UserPasswordEncoderInterface $passwordEncoder)
    {
        $values = json_decode($request->getContent());
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($passwordEncoder->encodePassword($user, $values->password));      
        $part = $this->getDoctrine()->getRepository(Partenaire::class)->findAll();
        if (count($violations))
        {
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }
        
        if($user->setPartenaire($part[0]))
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
       
        return $this->view($user, Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
      
    }


    /**
     * @Rest\View(StatusCode = 200)
     * @Rest\Put(
     *      path = "/comptes/{id}",
     *      name = "depot",
     * )
     * @ParamConverter("dpt", converter="fos_rest.request_body")
     */
    public function depot(Depot $dpt,Compte $cpt, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $part = $this->getDoctrine()->getRepository(Compte::class)->findAll();
        
        $dpt->setCaissier($user[0]);
        $dpt->setCompte($part[0]);
        $cpt->setDateDepot(new \DateTime());
        $dpt->setDateDepot(new \DateTime());
        $cpt->setMontant($cpt->getMontant()+$dpt->getMontantDepot());
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($dpt);
        $em->flush();

    }

}
