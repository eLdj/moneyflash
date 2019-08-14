<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class TransfertController extends FOSRestController
{
    /**
     * @Route("/transfert", name="transfert")
     */
    public function index()
    {
        return $this->render('transfert/index.html.twig', [
            'controller_name' => 'TransfertController',
        ]);
    }
}
