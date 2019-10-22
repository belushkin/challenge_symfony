<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use App\Service\UserManager;

class FavoriteController extends AbstractController
{

    /**
     * @Route("/favorites", name="app_favorite_movie_list")
     * @param Security $security
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Security $security)
    {
        return $this->render('favorite-list.html.twig', ['movies' => $security->getUser()->getMovieCollection()]);
    }
}
