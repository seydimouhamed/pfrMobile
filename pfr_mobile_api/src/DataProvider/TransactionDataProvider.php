<?php

namespace App\DataProvider;

use App\Entity\Transaction;
use App\Services\SendSmsService;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class TransactionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $request;
    private $security;
    private $sendSms;
    public function __construct(
        Security $security,
        RequestStack $requestStack)
    {
        $this->security =$security;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if($operationName ==="get_transaction"){
          return Transaction::class === $resourceClass;
        }
        
        return false;
        
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        
        
        // $data[]=$this->security->getUser();

        // return $data;
    }
}