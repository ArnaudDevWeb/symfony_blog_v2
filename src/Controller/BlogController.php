<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('bloglist', name: 'blog_list')]
    public function list(ArticleRepository $repo): Response
    {
        
        $articles = $repo -> findAll();

        return $this->render('blog/list.html.twig', [
            'articles' => $articles
        ]);
    }
}
