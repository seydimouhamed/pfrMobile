<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfilFixtures extends Fixture
{
       
    public static function getReferenceKey($i)
    {
        return sprintf('profil_%s',$i);
    }
    
    public function load(ObjectManager $manager)
    {
        $libelles = ["AdminAgence","AdminSysteme","Caissier","UserAgence"];


        foreach($libelles as $k => $lib)
        {
            $profil = new Profil();
            $profil-> setLibelle($lib);
            $manager->persist($profil);
            $this->addReference(self::getReferenceKey($k), $profil);

        }
        
        $manager->flush();
    }
}
