<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;

class FicheController extends AbstractController
{
    #[Route('/fiche/{id}', name: 'fiche')]
    public function index(Movie $movie, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        if(isset($_POST["mdp"]) && $_POST["mdp"] == 'admin'){
            $entityManager->remove($movie);
            $entityManager->flush();
            return $this->redirectToRoute('accueil');
        }

        return $this->render('fiche/index.html.twig', [
            'movie' => $movie,
        ]);
    }
}
