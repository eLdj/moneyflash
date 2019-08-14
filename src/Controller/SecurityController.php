<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\PartType;
use App\Form\UserType;
use App\Form\ProfilType;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Repository\ProfilRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN','Vous n\'avez accés aux ajout de partenaire');
        $user = new Utilisateur();
        $cmpt = new Compte();
        $part = new Partenaire();
         
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request); 
            
            $data = $request->request->all();
            $file = $request->files->all()['imageFile'];      
        
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
    
        $user->setRoles(["ROLE_SUPER_ADMIN_PARTENAIRE"]);
       
        $user->setImageFile($file);
        $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword())); 
        $user->setPartenaire($part);  
        $cmpt->setPartenaire($part);
        $cmpt->setNumero($part->getId()+$cmpt->getId()+$num);
        if($form->isSubmitted())
        {
            var_dump($form->isValid());die();
            $em = $this->getDoctrine()->getManager();
            $em->persist($part);
            $em->persist($cmpt);
            $em->persist($user);
            $em->flush();
            return $this->handleView($this->view(['status'=>'Enregistrement réussi'],Response::HTTP_CREATED));  
        }
      
        return $this->handleView($this->view($form->getErrors()));
 
    }

    /**
    * @Rest\Put(
    *    path = "/modif_user/{id}",
    *    name = "modif_user"
    * )
    */
    public function updateUser(Request $request,Utilisateur $user,UserPasswordEncoderInterface $encoder, ObjectManager $manager,UtilisateurRepository $userRepo)
    {
        $part = $this->getUser()->getPartenaire();
        if(!$user)
        {
            throw new HttpException(404,'Cet utilisateur n\'existe pas !');
        }
        $form=$this->createForm(UserType::class,$user);
        $data=$request->request->all();
        $form->submit($data);
        $form->handleRequest($request);
        $user->setPartenaire($part);
        if($form->isSubmitted()){
            $pwd=$encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($pwd);
            $manager->flush();
           return $this->handleView($this->view('L\'utilisateur a été  modifié !',Response::HTTP_OK));
        }
         
        return $this->handleView($this->view($form->getErrors()));
    }
    
    /**
     * @Route("/login_check", name="login", methods={"POST"})
     */
    public function login(){}

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Au revoir');
    }
    
}
