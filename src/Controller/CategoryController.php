<?php

namespace App\Controller;

use Exception;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
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

    #[Route('/categorie/{slug}', name: 'category_show')]
    public function show(CategoryRepository $repo, $slug): Response
    {
        $categorie = $repo -> findOneBy(['slug' => $slug]);
        
        return $this->render('category/show.html.twig', [
            'categorie' => $categorie
        ]);
    }

    #[Route("/supprimer-categorie/{slug}", name: "category_delete")]
    public function delete(Category $categorie, EntityManagerInterface $em) : Response
    {
        $em->remove($categorie);
        $em->flush();

        return $this->redirectToRoute('category_list');
    }
    
    #[Route("/nouvelle-categorie", name: "category_new")]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger) : Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //? Determiner le slug
            $slug = $slugger->slug($category->getName(). '-' .rand(10, 100));
            $category->setSlug($slug);
            
            $em->persist($category);
            
            try{
                $em->flush($category);
            }catch(Exception $e){
                    return $this->redirectToRoute('category_new');
            }
            return $this->redirectToRoute('category_show', array('slug' => $slug));
        }

        return $this->render('category/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route("/modifier-categorie/{slug}", name: "category_edit")]
    public function edit(Category $category, Request $request, EntityManagerInterface $em) : Response
    {
       $form = $this->createForm(CategoryType::class, $category);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid()){
            $em ->flush();
            return $this->redirectToRoute('category_list');
       }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

}

