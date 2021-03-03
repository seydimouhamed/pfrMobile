<?php
namespace App\DataPersister;

use App\Entity\Depot;
use App\Services\TransactionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class DepotDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    private $request;
    private $service;
    public function __construct(
        TransactionService $service,
        EntityManagerInterface $em,
        RequestStack $request)
    {
        $this->service =$service;
        $this->em=$em;
        $this->request = $request->getCurrentRequest();
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Depot;
    }

    public function persist($data, array $context = [])
    {
        if(isset($context['collection_operation_name']) and $context['collection_operation_name'] === 'post'){
            $data= $this->service->postDepot($data);
        }
        if(isset($context['item_operation_name']) and $context['item_operation_name'] === 'put'){
            dd('ici');
            $previousMontant = $this->request->get('previous_data')->getMontant();
           
            $this->service->putDepot($data, $previousMontant);
        }
        $this->em->persist($data);
        $this->em->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {
        if(!$data->getIsCanceled())
        {
            $data->setIsCanceled(true);
           $this->service->cancelDepot($data);
            // ajouter un champ annuler dans la base!
            $this->em->persist($data);
            $this->em->flush();
        }
        return 1;
    }

}