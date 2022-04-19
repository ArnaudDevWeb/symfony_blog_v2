<?php

namespace App\Controller;

use Exception;
use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    #[Route('/liste-des-tags', name: 'tag_list')]
    public function list(TagRepository $repo): Response
    {
        $tags = $repo -> findAll();
        
        return $this->render('tag/list.html.twig', [
            'tags' => $tags
        ]);
    }

    #[Route("/supprimer-tag/{id}", name: "tag_delete")]
    public function delete(Tag $tag, EntityManagerInterface $em) : Response
    {
        try {
            $em ->flush();
            $this->addFlash('sucess', "Tag supprimé avec succès");
        }catch (Exception $e){
            $this->addFlash('danger', "Echec de la suppression");
        }

        return $this->redirectToRoute('tag_list');
    }

    #[Route("/modifier-tag/{id}", name: "tag_edit")]
    public function edit(Tag $tag, Request $request, EntityManagerInterface $em) : Response
    {
       $form = $this->createForm(TagType::class, $tag);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid()){
            try {
                $em ->flush();
                $this->addFlash('sucess', "Le tag a bien été modifié");
            }catch (Exception $e){
                $this->addFlash('danger', "Echec de la modification du tag");
            }
            return $this->redirectToRoute('tag_list');
       }

        return $this->render('tag/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route("/nouveau-tag", name: "tag_new")]
    public function new(Request $request, EntityManagerInterface $em) : Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($tag);

            try{
                $em->flush($tag);
                $this->addFlash('success',"Création d'un tag réussi");
            }catch(Exception $e){
                $this->addFlash('danger', 'Echec de la création du tag');
                return $this->redirectToRoute('tag_new');
            }

            return $this->redirectToRoute('tag_show', array('id' => $tag->getId()));

        }

        return $this->render('tag/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route("/tag/{id}", name: "tag_show")]
    public function show(TagRepository $repo, $id): Response
    {
        
        $tag = $repo -> findOneBy(['id' => $id]);

        return $this->render('tag/show.html.twig', [
            'tag' => $tag
        ]);
    }

}
