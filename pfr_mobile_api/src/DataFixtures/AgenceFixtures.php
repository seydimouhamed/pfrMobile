<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Agence;
use App\Entity\Compte;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AgenceFixtures extends Fixture implements DependentFixtureInterface
{   
    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }

    public static function getReferenceAgenceKey($i)
    {
        return sprintf('age_%s',$i);
    }

    public static function getReferenceCompteKey($i)
    {
        return sprintf('compte_%s',$i);
    }
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr-FR');
        $k = 1;
        for($i = 1 ; $i <= 10; $i++){
            $agence = new Agence();
            $agence->setNom('agence_'.$i)
                   ->setTelephone($faker->phoneNumber())
                   ->setAdresse($faker->address())
                   ->setAdminAgence($this->getReference(UserFixtures::getReferenceAdminAgenceKey($i)));
            for($j=1; $j <= 2; $j++)
            {
                $agence->addUser($this->getReference(UserFixtures::getReferenceUserAgenceKey($k)));
                $k++;
            }
            $time = new \DateTime();
            $time->format('H:i:s \O\n Y-m-d');

            $compte = new Compte();
                $compte->setSolde(700000)
                       ->setCode('sndk'.$i)
                       ->setCreateAt($time);
                       $manager->persist($compte); 
            $agence->setCompte($compte);
            $manager->persist($agence);

            $this->addReference(self::getReferenceCompteKey($i), $compte);
            $this->addReference(self::getReferenceAgenceKey($i), $agence);
        }        

        $manager->flush();
    }
}
