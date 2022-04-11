<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/liste-des-categories', name: 'category_list')]
    public function list(CategoryRepository $repo): Response
    {
        $categories = $repo -> findAll();
        
        return $this->render('category/list.html.twig', [
            'categories' => $categories
        ]);
    }
}
