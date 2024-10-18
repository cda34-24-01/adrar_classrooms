<?php

namespace App\DataFixtures;

use App\Entity\CitationStagiaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CitationsFixtures extends Fixture implements DependentFixtureInterface
{
    public const CITATION_REFERENCE_TAG = 'citation-';
    public const CITATION_COUNT = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        $users = [];
        for ($i = 0; $i < self::CITATION_COUNT; $i++) {
            $user = $this->getReference(UsersFixtures::USERS_REFERENCE_TAG . rand(0, UsersFixtures::USERS_COUNT - 1));
            if(!in_array($user->getId(), $users)) {
                $citation = new CitationStagiaire();
                $citation->setAuteur($user);
                $citation->setJob($faker->jobTitle);
                $citation->setCitation($faker->paragraph);
                $users[] = $user->getId();
                $manager->persist($citation);
                $this->addReference(self::CITATION_REFERENCE_TAG . $i, $citation);
            } 
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UsersFixtures::class
        ];
    }
}
