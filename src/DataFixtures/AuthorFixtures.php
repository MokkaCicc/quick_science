<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AuthorFixtures extends Fixture
{
    static $numberAuthors = 20;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < AuthorFixtures::$numberAuthors; $i++) { 
            $firstName = $faker->firstName();
            $lastName = $faker->lastName;

            $author = new Author();
            $author
                ->setFirstName($firstName)
                ->setLastName($lastName)
            ;

            $tag = "author-" . $i;
            $this->addReference($tag, $author);
            $manager->persist($author);
        }

        $manager->flush();
    }
}
