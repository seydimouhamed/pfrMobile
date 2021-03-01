<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      collectionOperations={
 *        "get"={
 *               "method"="GET", 
 *               "path"="/agences",
 *                "security"="(is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé"
 *         },
 *         "post"={
 *               "method"="POST", 
 *               "path"="/agences",
 *                "security"="(is_granted('ROLE_AdminSysteme'))",
 *                "denormalization_context"={"groups"={"post:agence","post:compte","user:write"}},
 *                  "security_message"="Acces non autorisé"
 *         },
 *      },
 *      itemOperations={
 *           "get_agence_id"={ 
 *               "method"="GET", 
 *               "path"="/agences/{id}",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="(object.adminAgence==user or is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *           "get_agence_id_user"={ 
 *               "method"="GET", 
 *               "path"="/agences/{id}/users",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "normalization_context"={"groups"={"user:read"}},
 *                "security"="(object.adminAgence==user or is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *            "modifier_agence_id"={ 
 *               "method"="PUT", 
 *               "path"="/agences/{id}",
 *               "requirements"={"id"="\d+"},
 *                "security"="(object.adminAgence==user  or is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *            "block_agence_id"={ 
 *               "method"="DELETE", 
 *               "path"="/agences/{id}/block",
 *               "requirements"={"id"="\d+"},
 *                "security"="(is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *            "delete_agence_id"={ 
 *               "method"="DELETE", 
 *               "path"="/agences/{id}",
 *               "requirements"={"id"="\d+"},
 *                "security"="( is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Accès non autorisé",
 *          },
 *            "retablir_agence_id"={ 
 *               "method"="DELETE", 
 *               "path"="/agences/{id}",
 *               "requirements"={"id"="\d+"},
 *                "security"="( is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Accès non autorisé",
 *          }, 
 *            "block_agence_id_user_id"={ 
 *               "method"="DELETE", 
 *               "path"="/agences/{id}/users/{idUser}",
 *               "requirements"={"id"="\d+"},
 *                "security"="( is_granted('ROLE_AdminSysteme') or object.adminAgence==user )",
 *                  "security_message"="Accès non autorisé",
 *          }  
 *      }
 * )
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 */
class Agence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post:agence"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post:agence"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post:agence"})
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="agence")
     * @Groups({"user:read"})
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=Compte::class, cascade={"persist", "remove"})
     * @Groups({"post:agence"})
     */
    private $compte;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBlocked = false;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @Groups({"post:agence"})
     */
    public $adminAgence;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAgence($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAgence() === $this) {
                $user->setAgence(null);
            }
        }

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getIsBlocked(): ?bool
    {
        return $this->isBlocked;
    }

    public function setIsBlocked(bool $isBlocked): self
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    public function getAdminAgence(): ?User
    {
        return $this->adminAgence;
    }

    public function setAdminAgence(?User $adminAgence): self
    {
        $this->adminAgence = $adminAgence;

        return $this;
    }
}
