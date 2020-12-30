<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    static $numberCategories = -1;
    // minimum of 3 categories
    static $categoryTree = [
        "Espace" => [
            "Système solaire" => [
                "Soleil" => [],
                "Vénus" => []
            ],
            "Trou noir" => []
        ],
        "Medecine" => [
            "Cancer" => [],
            "Ophtalmologie" => []
        ],
        "News" => [
            "Politique" => [
                "France" => [],
                "USA" => [
                    "Trump"  => []
                ]
            ],
            "Catastrophe" => []
        ],
        "Biologie" => []
    ];

    public function load(ObjectManager $manager)
    {
        foreach (CategoryFixtures::$categoryTree as $key => $value) {
            $category = new Category();
            $category
                ->setName($key)
            ;
            
            CategoryFixtures::$numberCategories++;
            $tag = "category-" . CategoryFixtures::$numberCategories;
            $this->addReference($tag, $category);
            
            $this->createSubCategories($manager, $category, $value);
            $manager->persist($category);
        }

        $manager->flush();
    }

    private function createSubCategories(ObjectManager $manager, Category $rootCategory, Array $categories) {
        foreach ($categories as $key => $value) {
            $category = new Category();
            $category
                ->setName($key)
                ->setRootCategory($rootCategory)
            ;
            
            CategoryFixtures::$numberCategories++;
            $tag = "category-" . CategoryFixtures::$numberCategories;
            $this->addReference($tag, $category);
            
            $this->createSubCategories($manager, $category, $value);
            $manager->persist($category);
        }
    }
}
