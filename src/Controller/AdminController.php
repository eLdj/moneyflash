<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\PartType;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\PartenaireRepository;

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
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function createPart(Request $request,Partenaire $part,Utilisateur $user,Compte $cmpt, ConstraintViolationList $violations, UserPasswordEncoderInterface $passwordEncoder)
    {
        $values = json_decode($request->getContent());
        $part->setCreatedAt(new \DateTime());
        $cmpt->setDateDepot(new \DateTime());
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($passwordEncoder->encodePassword($user, $values->password));

        if (count($violations)) 
        {
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }
        
        if($user->setPartenaire($part) && $cmpt->setPartenaire($part))
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cmpt);
            $em->persist($user);
            $em->persist($part);
            $em->flush();
        }
       
        return $this->view($part, Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
    }
    
    /**
     * @Rest\Post(
     *    path = "/user",
     *    name = "app_user_create"
     * )
     *  @ParamConverter("user", converter="fos_rest.request_body")
     *  @IsGranted("ROLE_ADMIN")
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

}
