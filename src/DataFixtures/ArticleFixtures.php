<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        
        $tagDefault = new Tag();
        $tagDefault->setName('Badge par défaut');
        $manager->persist($tagDefault);

        for($i = 1; $i < 11; $i ++){

            $article = new Article();
            $article
            ->setTitle("Article n° $i")
            ->setContent("Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. 
            Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.")
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setSlug("article-$i")
            ->setCategory($this->getReference("cat" .$i))
            ->setIsPublished(true);
            $tag = new Tag();
            $tag->setName("Badge depuis l'article n° $i");
            $article->addTag($tag);
            $article->addTag($tagDefault);
            
            $manager->persist($tag);
            $manager->persist($article);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
