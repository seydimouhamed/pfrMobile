<?php

namespace App\Services;

use App\Repository\FraisRepository;
use App\Repository\TransactionRepository;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class TransactionService
{
    private $_iriconverter;
    private $_serializer;
    private $validator;
    private $repo;
    private $fraisRepo;
    private $security;

    public function __construct(
        FraisRepository $fraisRepo,
        IriConverterInterface $_iriconverter,
        SerializerInterface $_serializer,
        ValidatorInterface $validator,
        Security $security,
        TransactionRepository $repo)
    {
        $this->repo = $repo;
        $this->fraisRepo = $fraisRepo;
        $this->security = $security;
    }

    public function postTransaction($data)
    {
        if($data->getMontant()>=2000000)
        {
            $frais= $data->getMontant()*2/100;
        }
        else
        {
            $frais = $this->fraisRepo->getFrais($data->getMontant());
        }
        $currentUser=$this->security->getUser();
        $partDepot=$frais*1/10;
        $data->setCode($this->getCode())
        ->setDateAt($this->getCurrentDateTime())
        ->setAgentDepot($currentUser)
        ->setPartEtat($frais*4/10)
        ->setPartSyst($frais*3/10)
        ->setPartDepot($partDepot)
        ->setFrais($frais)
        ->setPartRetrait($frais*2/10);

        $this->updateSolde($data->getMontant(), $partDepot);
         
         return $data;
    }

    public function putTransaction($data)
    {
        $currentUser=$this->security->getUser();
        $montantRetrait= $data->getMontant() - $data->getFrais();
        $partRetrait= $data->getPartRetrait();
        $data->setAgentRetrait($currentUser);
        $data->setRetraitAt($this->getCurrentDateTime());
        $this->updateSolde($montantRetrait,$partRetrait,"retrait" );

        return $data;
        
    }

    public function getCode(){

        // return random_bytes($nbr);
        return hexdec(\uniqid());
    }

    public function getCurrentDateTime(){

        $datetime = new \DateTime();
        $datetime->format('H:i:s \O\n Y-m-d');
        return $datetime;
    }

    public function updateSolde($montant,$part,$type="depot", $compte=null){
        $newSolde = 0;
        if(!$compte)
        {
           $compte=$this->security->getUser()->getAgence()->getCompte();

        }
        if($type==="depot")
        {
            $newSolde= ($compte->getSolde() - $montant) + $part;
        }else{
            $newSolde= ($compte->getSolde() + $montant) + $part;
        }
        $compte->setSolde($newSolde);

        return $compte;
    }
    public function postDepot($data)
    {
       $mnt = $data->getMontant();
       $currentUser=$this->security->getUser();
       $compte = $data->getCompte();
       $newSolde = $compte->getSolde() + $mnt;
       // actualiser solde
       $compte->setSolde($newSolde);

       // setUser
       $data->setUser($currentUser)
            ->setDateAt($this->getCurrentDateTime());

     return $data;
    }
    public function putDepot($data, $previousMontant){
       $compte = $data->getCompte();
       $updatemnt = $data->getMontant();
       $newSolde = ($compte->getSolde() - $previousMontant) + $updatemnt;
       $compte->setSolde($newSolde);
       return;
    }
    public function cancelDepot($data){

        $montant = $data->getMontant();
        $compte= $data->getCompte();
        $newSolde = $compte->getSolde() - $montant;

        $compte = $compte->setSolde($newSolde);

        return;
    }

}