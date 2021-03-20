<?php

namespace App\DataProvider;

use App\Entity\Agence;
use App\Services\TransactionService;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;

final class TransactiontemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $transactionService;
    public function __construct(TransactionService $transactionService){

        $this->transactionService = $transactionService;
        
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if($operationName==="get_agence_id_transaction" ){
           
            return Agence::class === $resourceClass;
        }
        return false;
        
    }

    public function getItem(string $resourceClass,$id, string $operationName = null, array $context = []): iterable
    {
        $transactions = $this->transactionService->getAgenceTransactions($id);

        return $transactions;
    }
}