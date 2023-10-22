<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\AjoutLivreType;
use App\Form\ModifLivreType;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class LivreController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(LivresRepository $livresRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $livres = $paginator->paginate(
        $livresRepository->findAll(),
        $request->query->getInt('page', 1),
            10
        );
        return $this->render('home/index.html.twig', [
            'livres' => $livresRepository->findAll(),
        ]);
    }

    #[Route('/ajoutLivre', name: 'ajoutLivre', methods: ['GET','POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        //On crée un "nouveau livre"
        $livre = new Livres();

        // On crée le formulaire
        $form = $this->createForm(AjoutLivreType::class, $livre);

        // On traite la requête du formulaire
        $form->handleRequest($request);

        //On vérifie si le formulaire est soumis ET valide
        if($form->isSubmitted() && $form->isValid()){
            // On stocke
            try {
                $em->persist($livre);
                $em->flush();           
                $this->addFlash('success', 'Livre ajouté avec succès');
            } catch (FileException $e) {
                print_r($e);
            }

            // On redirige
            return $this->redirectToRoute('app_home');
        }
        return $this->render('livres/ajout.html.twig', [
            'form' => $form->createView()
        ]);

    }

    
    #[Route('/edition/{id}', name: 'edit', methods: ['GET','POST'])]
    public function edit(LivresRepository $livres, Request $request, EntityManagerInterface $em, $id): Response
    {
        //
        $livre = $livres->find($id); 
        // On crée le formulaire
        $livreForm = $this->createForm(ModifLivreType::class, $livre);

        // On traite la requête du formulaire
        $livreForm->handleRequest($request);

        //On vérifie si le formulaire est soumis ET valide
        if($livreForm->isSubmitted()){  

            // On stocke
            $em->persist($livre);
            $em->flush();

            $this->addFlash('success', 'Livre modifié avec succès');

            // On redirige
            return $this->redirectToRoute('app_home');
        }


        return $this->render('livres/modif.html.twig', [
            'form' => $livreForm->createView(),
            'livre' =>$livres->find($id)
        ]);
    }

    #[Route('/suppression/{id}', name: 'delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $em, $id, LivresRepository $livres): Response
    {
        $livre = $livres->find($id);      
        $em->remove($livre); 
        $em->flush(); 

        $this->addFlash(
            'success',
            'Le livre a été supprimé avec succès !'
        );
        return $this->render('home/index.html.twig', [
            'livres' => $livres->findAll(),
        ]);
    }

}