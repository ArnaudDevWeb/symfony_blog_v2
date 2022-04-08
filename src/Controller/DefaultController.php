<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function home(): Response
    {
        return $this->render('default/home.html.twig', []);
    }

    #[Route('/a-propos', name: 'about')]
    public function about(): Response
    {
        return $this->render('default/about.html.twig', []);
    }
}
