<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Movie;
use App\Repository\MovieRepository;


class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();


        return $this->render('accueil/index.html.twig', [
            'movies' => $movies,
        ]);
    }
}
