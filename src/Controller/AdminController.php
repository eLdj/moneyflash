<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\Partenaire;
use Twig\Profiler\Profile;
use App\Entity\Utilisateur;
use App\Repository\DepotRepository;
use App\Repository\CompteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bridge\Twig\Extension\HttpFoundationExtension;
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
     * @Rest\Post(
     *      path = "/depot",
     *      name = "depot",
     * )
     * @ParamConverter("dpt", converter="fos_rest.request_body")
     */
    public function depot(Request $request,  Depot $dpt,CompteRepository $cpt,ValidatorInterface $validator)
    {   
        $data = json_decode($request->getContent(),true);
        
        if(!$data)
        {
            $data = $request->reaquest->all();
        }

        $compte = $cpt->findOneBy(['numero'=>$data['numero']]);

        if(!$compte)
        {
            throw new HttpException(403,'Ce compte n\'existe pas !');
        }

        $errors = $validator->validate($dpt);
        if(count($errors))
        {
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
            $user = $this->getUser();
            $dpt->setCaissier($user);
            $dpt->setCompte($compte);
            $compte->setDateDepot(new \DateTime());
            $dpt->setDateDepot(new \DateTime());
            $compte->setMontant($compte->getMontant()+$dpt->getMontantDepot());

        $em = $this->getDoctrine()->getManager();
        $em->persist($dpt);
        $em->flush();

        return $this->handleView($this->view("Depot effectué avec succés", Response::HTTP_CREATED));
    }

     /**
     * @Rest\Post(
     *  path="/findnum",
     *  name="findnum"
     * )
     */
    public function findNum(Request $request,CompteRepository $cpt,SerializerInterface $serializer){

        $data = json_decode($request->getContent(),true);
            
        if(!$data){

            $data=$request->request->all();
        }

        $compte = $cpt->findOneBy(['numero'=>$data['numero']]);

        if(!$compte)
        {
            throw new HttpException(403,'Ce comptre n\'existe pas !');
        }


        $data = $serializer->serialize($compte, 'json',['groups'=>['find']]);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
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
