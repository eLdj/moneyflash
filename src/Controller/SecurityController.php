<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\PartType;
use App\Form\UserType;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class SecurityController extends FOSRestController
{
    private $actif = 'actif';
    private $bloque = 'bloque';
    /**
     * @Rest\Post(
     *    path = "/inscrit",
     *    name = "app_inscrit_create"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function inscrit(Request $request,ValidatorInterface $validator,UserPasswordEncoderInterface $passwordEncoder)
    {
        #$this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN','Vous n\'avez accés aux ajout de partenaire');
        $user = new Utilisateur();
        $cmpt = new Compte();
        $part = new Partenaire();
         
        $form = $this->createForm(UserType::class,$user);

            $data = $request->request->all();
            $file = $request->files->all()['imageFile'];      
        
        $form->submit($data);
        $form->handleRequest($request); 
        
        $form = $this->createForm(PartType::class,$part);   
       
        $form->submit($data);
        $form->handleRequest($request); 
        
        $num = random_int(100000, 999999); 
        $errors = $validator->validate($user);
             
        if(count($errors))
        {
            return new Response($errors, 500, [
            'Content-Type' => 'application/json'
            ]);
        }
    
        $user->setRoles(["ROLE_SUPER_ADMIN_PARTENAIRE"]);
        $user->setStatut($this->actif);
        $part->setStatut($this->actif);
        $user->setImageFile($file);
        $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword())); 
        $user->setPartenaire($part);  
        $cmpt->setPartenaire($part);
        $cmpt->setNumero($part->getId()+$cmpt->getId()+$num);

        if($form->isSubmitted())
        {
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
     *  path = "/partupdate/{id}",
     *  name= "partupdate"
     * )
     */
    Public function partUpdate(Request $request,Partenaire $part, ObjectManager $manager)
    {
        $form = $this->createForm(PartType::class,$part);
        $data=$request->request->all();
        $form->submit($data);
        if($form->isSubmitted()){
            $manager->flush();
           return $this->handleView($this->view('Le partenaire a été  modifié !',Response::HTTP_OK));
        }
         
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * @Rest\Post(
     *    path = "/adduser",
     *    name = "app_user_create"
     * )
     * @Rest\View(StatusCode = 201)
     */
    public function AddUser(Request $request,ValidatorInterface $validator,UserPasswordEncoderInterface $passwordEncoder)
    {
        #$this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN','Vous n\'avez accés aux ajout de partenaire');
        $user = new Utilisateur();
        $part =  $this->getUser()->getPartenaire();
         
        $form = $this->createForm(UserType::class,$user);
       
            
            $data = $request->request->all();
            $file = $request->files->all()['imageFile'];      
        $form->submit($data);        
        $errors = $validator->validate($user);
             
        if(count($errors))
        {
            return new Response($errors, 500, [
            'Content-Type' => 'application/json'
            ]);
        }
    
        $user->setRoles(["ROLE_SUPER_ADMIN_PARTENAIRE"]);
        $user->setStatut($this->actif);
        $user->setImageFile($file);
        $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword())); 
        $form->handleRequest($request); 
        if($part)
        {
            $user->setPartenaire($part);
        }
        else{
            $user->setPartenaire(null);
        }

        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
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
        
        $verifuser=$user->getPartenaire()->getId();
        $verifpart = null;
         
        if($part)
        {
            $verifpart=$part->getId();
            $user->setPartenaire($part);
        }
        else{
            $user->setPartenaire(null);
        }
        if($verifpart != $verifuser)
        {
            throw new HttpException(404,'Cet utilisateur ne vous appartient pas');
        }

        $form=$this->createForm(UserType::class,$user);
        $data=$request->request->all();
        $form->submit($data);
        $form->handleRequest($request);
        if($form->isSubmitted()){
          
            $pwd=$encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($pwd);
            $manager->flush();
           return $this->handleView($this->view('L\'utilisateur a été  modifié !',Response::HTTP_OK));
        }
         
        return $this->handleView($this->view($form->getErrors()));
    }
         
    /**
     * @Rest\Post(
     *      path = "/comptes/{id}",
     *      name = "new_compte"
     * )
     */
    public function addCompte(Partenaire $part,ValidatorInterface $validator)
    {
         $cmpt = new Compte;
       # $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Vous n\'avez accés aux ajout de partenaire');
        $errors = $validator->validate($cmpt);
        if(count($errors))
        {
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        
        $num = random_int(100000, 999999);
        $cmpt->setNumero($part->getId()+$cmpt->getId()+$num);
        $cmpt->setDateDepot(new \DateTime());
        $cmpt->setPartenaire($part);
        $em = $this->getDoctrine()->getManager();
        $em->persist($cmpt);
        $em->flush();

        return  $this->handleView($this->view('Compte ajouté avec succés', Response::HTTP_CREATED));
    }
    

    /**
     * @Rest\Get(
     *  path="/userblock/{id}",
     *  name="userblock"
     * )
     */
    public function userblock(Utilisateur $user,ObjectManager $manager)
    {
        $part = $this->getUser()->getPartenaire();
        $verifuser=$user->getPartenaire()->getId();
       
        $verifpart=null;
        
        if($part)
        {
            $verifpart=$part->getId();

        }
                
        if($verifpart != $verifuser)
        {
            throw new HttpException(403,'Cet utilisateur ne vous appartient pas');
        }


        if($user->getStatut() == $this->actif)
        {
            $user->setStatut($this->bloque);
        }
        else
        {
            $user->setStatut($this->actif);
        }

        $manager->persist($user);
        $manager->flush();
        
        return $this->handleView($this->view('Utilisateur mis à jour',Response::HTTP_OK));
    }


    /**
     * @Rest\Get(
     *  path="/partblock/{id}",
     *  name="partblock"
     * )
     */
    public function partblock(Partenaire $part,ObjectManager $manager)
    {          
        if($part->getStatut() == $this->actif)
        {
            $part->setStatut($this->bloque);
        }
        else
        {
            $part->setStatut($this->actif);
        }

        $manager->persist($part);
        $manager->flush();
        
        return $this->handleView($this->view('Partenaire mis à jour',Response::HTTP_OK));
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
        throw new \Exception(200,'Au revoir');
    }
    
}
