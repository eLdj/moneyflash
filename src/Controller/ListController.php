<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\DepotRepository;
use App\Repository\CompteRepository;
use App\Repository\TarifsRepository;
use JMS\Serializer\SerializerBuilder;
use App\Repository\ExpediteurRepository;
use App\Repository\PartenaireRepository;
use App\Repository\TransactionRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\BeneficiaireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use phpDocumentor\Reflection\Types\Nullable;

/**
 * @Route("/api")
 */
class ListController extends AbstractFOSRestController
{
    /**
     * @Route("/list", name="list")
     */
    public function index()
    {
        return $this->render('list/index.html.twig', [
            'controller_name' => 'ListController',
        ]);
    }


   /**
     * @Rest\Get("/listusers/{id}", 
     *  name="user",
     * )
     * @Rest\Get("/listusers", name="users")
     * @Rest\View()
     */
    public function listUser(UtilisateurRepository $users, SerializerInterface $serializer,$id=null)
    {
        if($id==null){

            $user = $users->findAll();
        }
        else{           
            $user = $users->findOneBy(['id'=>$id]);
        }
     
        $data = $serializer->serialize($user,'json');
        return new Response($data ,200,['Content-Type' => 'application/json']);    
    }


   /**
     * @Rest\Get("/listpart/{id}", 
     *  name="part",
     * )
     * @Rest\Get("/listparts", name="parts")
     * @Rest\View()
     */
    public function listPart(PartenaireRepository $parts, SerializerInterface $serializer,$id=null)
    {
        if($id==null){

            $part = $parts->findAll();
        }
        else{           
            $part = $parts->findOneBy(['id'=>$id]);
        }
     
        $data = $serializer->serialize($part,'json');
        return new Response($data ,200,['Content-Type' => 'application/json']);    
    }
}
