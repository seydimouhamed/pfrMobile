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
            $montant = 5500;
            $frais = 500;
            $transaction->setCompte($this->getReference(AgenceFixtures::getReferenceCompteKey($faker->numberBetween(1,9))));
            $client = new Client();
            $client->setTelephone($faker->phoneNumber())
                    ->setCni('11211221211')
                    ->setnomComplet('Client depot'.$i);
            $transaction->setAgentDepot($this->getReference(UserFixtures::getReferenceUserAgenceKey($faker->numberBetween(1,20))))
                         ->setDepotClient($client)
                         ->setType('depot')
                         ->setCode('celkdqjskdsqklqsdkmlqsdmqsd')
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
}
