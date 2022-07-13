<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Habitat;
use App\Entity\Destination;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $fake = Factory::create();

        for($u=0;$u < 10; $u++){
            $user = new User();
            $passHash = $this->encoder->hashPassword($user, 'pass');
            $user->setEmail($fake->email)
                ->setPassword($passHash)
                ->setNom($fake->word());
            
           $manager->persist($user);
           for($hab=0; $hab < random_int(5,15);$hab++){
             $habitat =(new Habitat())->setUser($user)
                  ->setTitre($fake->text(50))
                  ->setAdresse($fake->text(70))
                  ->setPresentation($fake->text(300))
                  ->setPrix($fake->randomFloat())
                  ->setSuperficie($fake->randomNumber())
                  ->setCapaciteAccueil($fake->numberBetween(0, 20))
                  ->setDateOuvertureAu($fake->dateTime())
                  ->setDateOuvertureDu($fake->dateTime())
                  ->setHeureArriveeAu(new \DateTime())
                  ->setHeureArriveeDu(new \DateTime())
                  ->setHeureDepartDu(new \DateTime())
                  ->setHeureDepartAu(new \DateTime())
                  ->setDestination((new Destination())->setDepartement($fake->randomNumber())
                                   ->setPays($fake->text(50)));

                  $manager->persist($habitat);
           }
        }
        $manager->flush();
   }
}