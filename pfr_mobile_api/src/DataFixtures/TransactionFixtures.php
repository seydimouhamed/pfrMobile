<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Client;
use App\Entity\Transaction;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\AgenceFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TransactionFixtures extends Fixture implements DependentFixtureInterface
{
        
    public function getDependencies()
    {
        return array(
            AgenceFixtures::class
        );
    }
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr-FR');
        // Dépot 
         for($i= 0; $i <= 20; $i++){
            $transaction= new Transaction();
            $time = new \DateTime();
            $time->format('H:i:s \O\n Y-m-d');
            $montant = 50000;
            $frais = 2500;
            $transaction->setCompteDepot($this->getReference(AgenceFixtures::getReferenceCompteKey($faker->numberBetween(1,9))));
            
            // client dépot
            $clientDepot = new Client();
            $clientDepot->setTelephone($faker->phoneNumber())
                    ->setCni(''.(\random_int(10*pow(10, 16), 9.99999999 * pow(10, 17))))
                    ->setnomComplet('Prenom NOMCD'.$i);
                
            // client dépot
            $clientRetrait = new Client();
            $clientRetrait->setTelephone($faker->phoneNumber())
                        ->setCni(''.(\random_int(10*pow(10, 16), 9.99999999 * pow(10, 17))))
                        ->setnomComplet('Prenom NOMCR'.$i);

            $transaction->setAgentDepot($this->getReference(UserFixtures::getReferenceUserAgenceKey($faker->numberBetween(1,20))))
                         ->setDepotClient($clientDepot)
                         ->setRetraitClient($clientRetrait)
                         ->setCode(''.(\random_int(pow(10, 9), 9.99999999 * pow(10, 10))))
                         ->setDateAt($time)
                         ->setMontant($montant)
                         ->setFrais($frais)
                         ->setPartDepot($frais*1/10)
                         ->setPartEtat($frais*4/10)
                         ->setPartSyst($frais*3/10)
                         ->setPartRetrait($frais*2/10);
            
            $manager->persist($transaction);
         }
        $manager->flush();
    }

    // public function getCode($nbr){

    //     dd(base64_encode(random_bytes($nbr)));
    //     // return hexdec(\uniqid());
    // }

    // public function secure_rand($min, $max)
    // {
    //     $nbr= \random_int($min, $max);
    //    dd($nbr);

    //    return $nbr;
    //}
}
