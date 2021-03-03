<?php

namespace App\DataProvider;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class UserCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $request;
    private $security;
    public function __construct(
        Security $security,
        RequestStack $requestStack)
    {
        $this->security =$security;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if($operationName ==="get_current_user"){

          return User::class === $resourceClass;
        }
        
        return false;
        
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        
        
        $data[]=$this->security->getUser();

        return $data;
    }
}