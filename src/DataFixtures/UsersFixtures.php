<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UsersFixtures extends Fixture
{
    public const USERS_REFERENCE_TAG = 'users-';
    public const USERS_COUNT = 10;

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        
        for ($i = 0; $i < self::USERS_COUNT; $i++) { 
            $users = new Users();
            $users->setEmail($faker->email);
            $users->setRoles($faker->words);
            $password = $faker->password(10);
            $users->setPassword(password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]));
            $users->setUsername($faker->word);
            $users->setLastname($faker->lastName);
            $users->setFirstname($faker->firstName);
            $users->setCreatedAt($faker->dateTimeThisMonth);

            $manager->persist($users);
            $this->addReference(self::USERS_REFERENCE_TAG . $i, $users);
        }

        $manager->flush();
    }
}
