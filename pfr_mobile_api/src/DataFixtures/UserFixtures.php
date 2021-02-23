<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    private $_encoder; 
    
    public function __construct(UserPasswordEncoderInterface $_encoder)
    {
        $this->_encoder = $_encoder;
    }
    
    public static function getReferenceAppKey($i)
    {
        return sprintf('app_%s',$i);
    }
    
    public static function getReferenceFormKey($i)
    {
        return sprintf('form_%s',$i);
    }
    
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr-FR');
        for($j = 0; $j <= 3; $j++){

            $profil=$this->getReference(ProfileFixtures::getReferenceKey($j));
            $nbrUserProfil=4;
            if($profil->getLibelle()=="AdminAgence"){
                $nbrUserProfil=10;
            }
        }

        $manager->flush();
    }
}
