<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api")
 */
class AdminController extends FOSRestController
{   
    /**
     * @Rest\Get("/employes")
     */
    public function index()
    {
        $repo=$this->getDoctrine()->getRepository(Utilisateur::class);
        $employes=$repo->findAll();
        return $this->handleView($this->view($employes));
    }

    /**
     * @Get(
     *      path = "/user/{id}",
     *      name="app_article_show"   
     * )
     * @View
     */
    public function show(Utilisateur $user)
    {
        return $this->handleView($this->view($user));
    }
}
