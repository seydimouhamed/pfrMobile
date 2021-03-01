<?php
namespace App\DataPersister;

use App\Entity\Agence;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class AgenceDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    private $request;
    public function __construct(
        EntityManagerInterface $em,
        RequestStack $request)
    {
        $this->em=$em;
        $this->request = $request->getCurrentRequest();
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Agence;
    }

    public function persist($data, array $context = [])
    {
        $this->em->persist($data);
        $this->em->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {
        if($context['item_operation_name']==="delete_agence_id")
        {
            $data->setIsDeleted(true);
            $data->getAdminAgence()->setIsDeleted(true);
            foreach($data->getUsers() as $u)
            {
                $u->setIsDeleted(true);
            }
            $this->block($data);

        }
        if($context['item_operation_name']==="block_agence_id")
        {
            $data->setIsBlocked(true);
            $data->getAdminAgence()->setIsBlocked(true);
            foreach($data->getUsers() as $u)
            {
                $u->setIsBlocked(true);
            }
        }
        if($context['item_operation_name']==="retablir_agence_id")
        {
            $data->setIsBlocked(false);
            $data->getAdminAgence()->setIsBlocked(false);
            foreach($data->getUsers() as $u)
            {
                $u->setIsBlocked(false);
            }
            $this->block($data, false);
        }
        if($context['item_operation_name']==="block_agence_id_user_id")
        {
            $idUser=$this->request->get('idUser');
           // dd($idUser);
            $user=($data->getUsers())->filter(function($u) use ($idUser){
                // dd($u->getID());
                return +$idUser=== $u->getID();
            });
            ($user[0])->setIsBlocked(!($user[0])->getIsBlocked());
        }
        $this->em->persist($data);
        $this->em->flush();
    }

    public function block($data,$bool= true)
    {
    
        $data->setIsBlocked($bool);
        $data->getAdminAgence()->setIsBlocked($bool);
        foreach($data->getUsers() as $u)
        {
            $u->setIsBlocked($bool);
        }
    }
}