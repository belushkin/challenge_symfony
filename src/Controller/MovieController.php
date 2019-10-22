<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\FavoriteMovie\FavoriteMovieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class MovieController extends AbstractController
{

    /**
     * @Route("/movies", name="app_movie_list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Security $security, Request $request)
    {
        $movieRepository = $this->getDoctrine()->getRepository(Movie::class);

        $user           = $security->getUser();
        $movies         = $movieRepository->findAll();
        $selectedMovies = $user->getMovieCollection();

        $form = $this->createForm(FavoriteMovieType::class, null, [
            'movies'            => $movies,
            'selectedMovies'    => $selectedMovies
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if (!empty($data['favorite'])) {

                $om = $this->getDoctrine()->getManager();
                $user->clearMovies();

                foreach ($data['favorite'] as $favoriteMovie) {
                    $user->addMovie($favoriteMovie);
                }
                $om->persist($user);
                $om->flush();
            }
        }

        return $this->render('movie-list.html.twig', [
            'movies' => $movies,
            'form' => $form->createView()
        ]);
    }
}
