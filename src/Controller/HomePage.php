<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePage extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'titre' => 'Bienvenue sur notre site'
        ]);
    }

    #[Route('/apropos', name: 'apropos')]
    public function boutique(): Response
    {
        return $this->render('apropos.html.twig', [
            'titre' => 'Bienvenue sur notre apropos'
        ]);
    }


}
