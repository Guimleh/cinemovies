<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\FichierType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Movie;
use App\Service\OMDBAPI;


class ImportMasseController extends AbstractController
{
    #[Route('/import/masse', name: 'import_masse')]
    public function index(Request $request, ManagerRegistry $doctrine, OMDBAPI $db): Response
    {
        $form = $this->createForm(FichierType::class);
        $form->handleRequest($request);
        $entityManager = $doctrine->getManager();
        if ($form->isSubmitted() && $form->isValid()) {

            $csvFile = $form->get("file")->getData();

            // instantiation, when using it as a component

            $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

            // decoding CSV contents
            $data = $serializer->decode(file_get_contents($csvFile->getPathname()), 'csv');
            foreach($data as $movie ){
                $movie2 =new Movie();
                $movie2->setName($movie['name']);
                $movie2->setMark($movie['mark']);
                $movie2->setPlot($movie['plot']);
                $movie2->setNbVotes(1);
                
                $movie_omdb = $db->omdb($movie2);

                if($movie_omdb["Response"] != "False"){
                    $movie2->setName($movie_omdb["Title"]);
                    $movie2->setPlot($movie_omdb["Plot"]);
                    $entityManager->persist($movie2);
                    $entityManager->flush();
                    //return $this->redirectToRoute("ajouter_film");
                }
                else{
                    $error =true;
                }
            }
        }
        return $this->renderForm('import_masse/index.html.twig', [
            'form' => $form,
            
        ]);
    }
}

