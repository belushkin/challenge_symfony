<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends AbstractController
{

    /**
     * @Route("/movies", name="app_movie_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $movieRepository = $this->getDoctrine()->getRepository(Movie::class);

        return $this->render('movie-list.html.twig', ['movies' => $movieRepository->findAll()]);
    }
}