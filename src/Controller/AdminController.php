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
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("part", converter="fos_rest.request_body")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @ParamConverter("cmpt", converter="fos_rest.request_body")
     * @IsGranted("ROLE_SUPERUSER")
     *   
     */
    public function createPart(Request $request,Partenaire $part,Utilisateur $user,Compte $cmpt, ConstraintViolationList $violations, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new Utilisateur();
        $values = json_decode($request->getContent());
        $part->setCreatedAt(new \DateTime());
        $cmpt->setDateDepot(new \DateTime());
        $user->setRoles(['ROLE_SUPERADMIN']);
        $user->setPassword($passwordEncoder->encodePassword($user, $values->password));

        if (count($violations)) {
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

}
