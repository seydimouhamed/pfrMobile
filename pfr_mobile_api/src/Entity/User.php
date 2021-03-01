<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *      subresourceOperations= {
 *         "depots_get_subresource"= {
 *               "path"="/caissiers/{id}/depots",
 *          },
 *     },
 *      collectionOperations={
 *        "get"={
 *               "method"="GET", 
 *               "path"="/admin/users",
 *                "security"="(is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé"
 *         },
 *         "post"={
 *               "method"="POST", 
 *               "path"="/users",
 *                "security"="(is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé"
 *         },
 *      },
 *      itemOperations={
 *           "get_user_id"={ 
 *               "method"="GET", 
 *               "path"="/admin/users/{id}",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="(object==user or is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *           "get_useragence_id"={ 
 *               "method"="GET", 
 *               "path"="/users/{id}/useragence",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="(object==user or (is_granted('ROLE_AdminAgence') && object.agence ===user.agence) or is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *           "get_user_id_transactions"={ 
 *               "method"="GET", 
 *               "path"="/users/{id}/transactions",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "normalization_context"={"groups"={"get:trans"}},
 *                "security"="(object==user or (is_granted('ROLE_AdminAgence') && object.agence ===user.agence) or is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *           "get_user_id_commissions"={ 
 *               "method"="GET", 
 *               "path"="/users/{id}/commissions",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "normalization_context"={"groups"={"get:com"}},
 *                "security"="(object==user or (is_granted('ROLE_AdminAgence') && object.agence ===user.agence) or is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *           "delete_user_id"={ 
 *               "method"="DELETE", 
 *               "path"="/admin/users/{id}",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="(is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *           "block_user_id"={ 
 *               "method"="DELETE", 
 *               "path"="/admin/users/{id}/block",
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="(is_granted('ROLE_AdminSysteme') and object!==user)",
 *                  "security_message"="Acces non autorisé",
 *          },
 *       },
 *       normalizationContext={"groups"={"user:read","resumeUser"}},
 *       denormalizationContext={"groups"={"user:write"}},
 *       attributes={
 *          "security"="is_granted('ROLE_AdminSysteme') or is_granted('ROLE_AdminAgence')",
 *          "security_message"="Acces non autorisé",
 *          "pagination_enabled"=true,
 *          "pagination_client_items_per_page"=true, 
 *          "pagination_items_per_page"=5}
 *    
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isDeleted"})
 * @ApiFilter(SearchFilter::class, properties={"id":"exact","profil.libelle": "exact"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Orm\Table("`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read", "user:write","resumeUser"})
     * @Assert\NotBlank
     */
    private $username;

    // /**
    //  * @ORM\Column(type="json")
    //  */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({ "user:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"user:read", "user:write"})
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @Groups({"user:read", "user:write"})
     */
    private $profil;


    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="users")
     */
    public $agence;

    /**
     * @ORM\OneToMany(targetEntity=Depot::class, mappedBy="user")
     * @\ApiPlatform\Core\Annotation\ApiSubresource()
     */
    private $depots;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="agentDepot")
     * @Groups({"get:trans","get:com"})
     */
    private $depotAgents;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="agentRetrait")
     * @Groups({"get:trans","get:com"})
     */
    private $retraitAgents;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBlocked = false;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->depots = new ArrayCollection();
        $this->depotAgents = new ArrayCollection();
        $this->retraitAgents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }


    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setUser($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getUser() === $this) {
                $depot->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getDepotAgents(): Collection
    {
        return $this->depotAgents;
    }

    public function addDepotAgent(Transaction $depotAgent): self
    {
        if (!$this->depotAgents->contains($depotAgent)) {
            $this->depotAgent[] = $depotAgent;
            $depotAgent->setAgentDepot($this);
        }

        return $this;
    }

    public function removeDepotAgent(Transaction $depotAgent): self
    {
        if ($this->depotAgents->removeElement($depotAgent)) {
            // set the owning side to null (unless already changed)
            if ($depotAgent->getAgentDepot() === $this) {
                $depotAgent->setAgentDepot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getRetraitAgents(): Collection
    {
        return $this->retraitAgents;
    }

    public function addRetraitAgent(Transaction $retraitAgent): self
    {
        if (!$this->retraitAgents->contains($retraitAgent)) {
            $this->retraitAgents[] = $retraitAgent;
            $retraitAgent->setAgentRetrait($this);
        }

        return $this;
    }

    public function removeRetraitAgent(Transaction $retraitAgent): self
    {
        if ($this->retraitAgents->removeElement($retraitAgent)) {
            // set the owning side to null (unless already changed)
            if ($retraitAgent->getAgentRetrait() === $this) {
                $retraitAgent->setAgentRetrait(null);
            }
        }

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
}
