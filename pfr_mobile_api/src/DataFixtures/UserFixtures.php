<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\DataFixtures\ProfilFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    private $_encoder; 
    
    public function __construct(UserPasswordEncoderInterface $_encoder)
    {
        $this->_encoder = $_encoder;
    }
    
    public function getDependencies()
    {
        return array(
            ProfilFixtures::class
        );
    }
    public static function getReferenceAdminAgenceKey($i)
    {
        return sprintf('aga_%s',$i);
    }
    public static function getReferenceCaissierKey($i)
    {
        return sprintf('cs_%s',$i);
    }
    public static function getReferenceAdminSystemeKey($i)
    {
        return sprintf('as_%s',$i);
    }
    public static function getReferenceUserAgenceKey($i)
    {
        return sprintf('ua_%s',$i);
    }
    
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr-FR');
        for($j = 0; $j <= 3; $j++){

            $profil=$this->getReference(ProfilFixtures::getReferenceKey($j));
            $nbrUserProfil=2;
            if($profil->getLibelle()==="AdminAgence"){
                $nbrUserProfil=10;

            }
            if($profil->getLibelle()==="Caissier"){
                $nbrUserProfil=4;

            }
            if($profil->getLibelle()==="UserAgence"){
                $nbrUserProfil=20;
            }

            for($i=1; $i <= $nbrUserProfil; $i++)
            {
                $user = new User();
                $user->setFirstname($faker->firstName)
                     ->setLastname($faker->lastName)
                     ->setPassword($this->_encoder->encodePassword($user, 'passe123'))
                     ->setProfil($profil)
                     ->setIsBlocked(0)
                     ->setIsDeleted(0)
                     ->setEmail($faker->email)
                     ->setUsername(\strtolower($profil->getLibelle()).$i);
                     if($profil->getLibelle()=="AdminAgence"){
                        $this->setReference(self::getReferenceAdminAgenceKey($i), $user);
                    }
                    elseif($profil->getLibelle()=="Caissier"){
                        $this->setReference(self::getReferenceCaissierKey($i), $user);
                    }
                    elseif($profil->getLibelle()=="UserAgence"){
                        $this->setReference(self::getReferenceUserAgenceKey($i), $user);
                    }elseif($profil->getLibelle()=="AdminSysteme"){
                        $this->setReference(self::getReferenceAdminSystemeKey($i), $user);
                    }
                    
                     $manager->persist($user);
            }
        }

        $manager->flush();
    }
}
