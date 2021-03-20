<?php
namespace App\DataPersister;

use App\Entity\Agence;
use App\Entity\Transaction;
use App\Services\TransactionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class TransactionDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof Transaction;
    }

    public function persist($data, array $context = [])
    {
        // dd($data);
        if(
            isset($context['item_operation_name']) && 
            $context['item_operation_name'] === 'put_transaction_id'){
            $data= $this->service->putTransaction($data);
            $this->em->persist($data);
            $this->em->flush();
            $this->service->sendSMSRetrait($data);
        }
        if(
            isset($context['collection_operation_name']) &&
            $context['collection_operation_name'] === 'post_transaction'){

            $data= $this->service->postTransaction($data);
            $this->em->persist($data);
            $this->em->flush();
            $this->service->sendSMSDepot($data);
        }
        //dd($data);
        return $data;
    }

    public function remove($data, array $context = [])
    {

        //$data->setIsBlocked(!$data->getIsBlocked());
        $this->em->persist($data);
        $this->em->flush();
    }

}