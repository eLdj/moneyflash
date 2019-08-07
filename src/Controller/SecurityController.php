<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Compte;
use App\Form\PartType;

/**
 * @Route("/api")
 */
class SecurityController extends FOSRestController
{
    /**
     * @Rest\Post(
     *    path = "/inscrit",
     *    name = "app_inscrit_create"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function inscrit(Request $request,ValidatorInterface $validator,UserPasswordEncoderInterface $passwordEncoder)
    {
        $data = json_decode($request->getContent(),true);
        $user = new Utilisateur();
        $cmpt = new Compte();
        $part = new Partenaire();
         
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if(!$data)
        {
            $data = $request->request->all();
            $file = $request->files->all()['imageFile'];      
        } 
        $form->submit($data);
        
        $form = $this->createForm(PartType::class,$part);   
        $form->handleRequest($request); 
        $form->submit($data);

        $num = random_int(100000, 999999);  
        $errors = $validator->validate($user);
             
        if(count($errors))
        {
            return new Response($errors, 500, [
            'Content-Type' => 'application/json'
            ]);
        }
       
        $cmpt->setPartenaire($part);
        $cmpt->setNumero($part->getId()+$cmpt->getId()+$num);
        if($form->isSubmitted())
        {
            $user->setRoles(["ROLE_SUPER_ADMIN_PARTENAIRE"]);
            $user->setImageFile($file);
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword())); 
            $user->setPartenaire($part);    
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($part);
        $em->persist($cmpt);
        $em->persist($user);
        $em->flush();
        return $this->handleView($this->view('Enregistrement réussi', Response::HTTP_CREATED));
    }
      
    /**
     * @Route("/login_check", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Au revoir');
    }
    
}
