<?php
namespace App\DataPersister;

use App\Entity\User;
use App\Exception\AutorisationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;

final class UserDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    private $_encoder;
    private $_request;
    public function __construct(
        Security $security,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $_encoder,
        RequestStack $request)
    {
        $this->em=$em;
        $this->security = $security;
        $this->_encoder = $_encoder;
        $this->_request = $request->getCurrentRequest();
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        $currentUser = $this->security->getUser();
        
        $cuProfil = $currentUser->getProfil()->getLibelle();
        $usertoAddProfil=$data->getProfil()->getLibelle();
        if(($cuProfil==="AdminSysteme" &&  $usertoAddProfil==="Caissier") || ($cuProfil=="AdminAgence" && $usertoAddProfil==="UserAgence"))
        {
            $encodePwd = $this->_encoder->encodePassword($data,$data->getPassword());
            $data->setPassword($encodePwd);
            if($cuProfil=="AdminAgence")
            {
                $data->setAgence($currentUser->getAgence());
            }
            $this->em->persist($data);
            $this->em->flush();
            return $data;
        }else{
            
            throw new AutorisationException('Vous n\'avez l\'autorisation de créer ce type d\'utilisateur à cette endroit!');
        }
    }

    public function remove($data, array $context = [])
    {

        if($context['item_operation_name']==="block_user_id")
        {
            // dd($data->getProfil()->getLibelle());
            if($data->getProfil()->getLibelle()==="AdminSysteme"){
             return new JsonResponse(json_encode(array('error')),Response::HTTP_BAD_REQUEST,[],true);
            }
            $data->setIsBlocked(!$data->getIsBlocked());
        }
        if($context['item_operation_name']==="delete_user_id")
        {
            $data->setIsDeleted(true);

        }
        $this->em->persist($data);
        $this->em->flush();
    }
}