<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\MovieType;
use App\Entity\Movie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpClient\HttpClient;
use App\Service\OMDBAPI;

class AjouterFilmController extends AbstractController
{


    #[Route('/ajouter-film', name: 'ajouter_film')]
    public function index(Request $request, ManagerRegistry $doctrine, OMDBAPI $db): Response
    {
        $error =false;
        $entityManager = $doctrine->getManager();
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $error =false;
            $movie = $form->getData();
            $movie_omdb = $db->omdb($movie);
            if($movie_omdb["Response"] != "False"){
                $movie->setName($movie_omdb["Title"]);
                $movie->setPlot($movie_omdb["Plot"]);
                $entityManager->persist($movie);
                $entityManager->flush();
                return $this->redirectToRoute("ajouter_film");
            }
            else{
                $error =true;
            }
            
        }

        return $this->renderForm('ajouter_film/index.html.twig', [
            'form' => $form,
            'erreur' => $error,
        ]);
    }
}
