<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer un titre pour l\'article'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 75,
                        'minMessage' => 'Le titre doit contenir au moins {{ limit }} caractères.',
                        'minMessage' => 'Le titre doit contenir au maximum {{ limit }} caractères.'
                    ])
                ]
            ])
            // NotBlank, lengh mini a 100
            ->add('content', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer un contenu pour votre article'
                    ]),
                    new Length([
                        'min' => 50,
                        'minMessage' => 'Votre contenu doit au moins contenir {{100}} caractères.'
                    ])
                ]
            ]) 
            ->add('isPublished', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
