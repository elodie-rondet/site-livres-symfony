<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
   /* private Livre $livre;

    public function __construct(Livre $livre) {
        $this -> livre = $livre;
    }*/
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        //$livres = $this -> livre->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
