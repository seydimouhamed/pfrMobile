<?php

namespace App\DataFixtures;

use App\Entity\Frais;
use Doctrine\Persistence\ObjectManager;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;

class FraisFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {        
        // $doc = $request->files->get("document");
        $doc ="/home/seydina/frais.ods";  
        $file= IOFactory::identify($doc);
        
        $reader= IOFactory::createReader($file);

        $spreadsheet=$reader->load($doc);
        
        $tab_tarif= $spreadsheet->getActivesheet()->toArray();
        // dd($tab_tarif);
        
        for($i=1; $i <count($tab_tarif);  $i++){
            $frais = new Frais();
            $frais->setMontant($tab_tarif[$i][0])
                ->setFrais($tab_tarif[$i][1]);
            
                $manager->persist($frais);
        }
      
        

        $manager->flush();
    }
}
