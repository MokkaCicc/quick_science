<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Magazine;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MagazineFixtures extends Fixture
{
    static $numberMagazines = 100;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $intialReleaseDate = new DateTime('1913-04-01');

        for ($i=0; $i < MagazineFixtures::$numberMagazines; $i++) { 
            $title = $faker->sentence($nbrwords=6, $variableNbWords=true);
            $number = $i + 1;
            // A magazine is release each month.
            $releaseDate = $intialReleaseDate;
            $intialReleaseDate->modify('first day of next month');

            $magazine = new Magazine();
            $magazine
                ->setTitle($title)
                ->setNumber($number)
                ->setReleaseDate(clone $releaseDate);
            ;

            $tag = "magazine-" . $i;
            $this->addReference($tag, $magazine);
            $manager->persist($magazine);
        }

        $manager->flush();
    }
}
