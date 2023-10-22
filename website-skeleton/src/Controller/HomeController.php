<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livres;
use App\Form\AjoutLivreType;
use App\Repository\LivresRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(LivresRepository $livresRepository): Response
    {
        $livres = $livresRepository->findAll();
        return $this->render('home/index.html.twig', [
            'livres' => $livresRepository->findAll(),
        ]);
    }

    #[Route('/livre/{id}', name: 'livre')]
    public function show(LivresRepository $livre, $id): Response
    {
        return $this->render('home/edit.html.twig', ['livre' =>$livre->find($id)]);
    }


}
