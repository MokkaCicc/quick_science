<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use App\Entity\Magazine;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    static $numberArticles = 1000;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < ArticleFixtures::$numberArticles; $i++) { 
            $title = $faker->sentence($nbWords=6, $variableNbWords=true);
            $description = $faker->paragraph($nbSentences=3, $variableNbSentences=true);
            $page = rand(5, 130);
            $magazineTag = "magazine-" . rand(0, MagazineFixtures::$numberMagazines-1);
            $magazine = $this->getReference($magazineTag);
            $authorTag = "author-" . rand(0, AuthorFixtures::$numberAuthors-1);
            $author = $this->getReference($authorTag);

            $article = new Article();
            $article
                ->setTitle($title)
                ->setDescription($description)
                ->setPage($page)
                ->setMagazine($magazine)
                ->setAuthor($author)
            ;

            $numberCategories = rand(1, 3);
            for ($j=0; $j < $numberCategories; $j++) {
                $categoryTag = "category-" . rand(0, CategoryFixtures::$numberCategories-1);
                $category = $this->getReference($categoryTag);
                $article->addCategory($category);
            }

            $tag = "article-" . $i;
            $this->addReference($tag, $article);
            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            MagazineFixtures::class,
            AuthorFixtures::class,
            CategoryFixtures::class
        );
    }
}
