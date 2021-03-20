<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompteRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *      normalizationContext={"groups"={"profil:read"}},
 *      denormalizationContext={"groups"={"profil:write"}},
 *      itemOperations={
 *           "put_compte_id"={ 
 *               "method"="PUT", 
 *               "path"="/comptes/{id}",
 *                 "serializer"=false,
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="(is_granted('ROLE_AdminSysteme') or is_granted('ROLE_AdminAgence') )",
 *                  "security_message"="Acces non autorisé",
 *          },
 *           "get_compte_id"={ 
 *               "method"="get", 
 *               "path"="/comptes/{id}",
 *                 "serializer"=false,
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "security"="(is_granted('ROLE_AdminSysteme') or is_granted('ROLE_AdminAgence'))",
 *                  "security_message"="Acces non autorisé",
 *          }
 *},
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isDeleted"})
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 */
class Compte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post:compte"})
     */
    private $code;

    /**
     * @ORM\Column(type="float")
     * @Groups({"post:compte","util"})
     */
    private $solde;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"post:compte"})
     */
    private $createAt;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="compteDepot")
     * @Groups({"get:allTrans", "get:comp:ag"})
     */
    private $transactionDepots;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="compteRetrait")
     * @Groups({"get:allTrans", "get:comp:ag"})
     */
    private $transactionRetraits;

    /**
     * @ORM\OneToMany(targetEntity=Depot::class, mappedBy="compte")
     */
    private $depots;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBlocked = false;

    /**
     * @ORM\OneToOne(targetEntity=Agence::class, cascade={"persist", "remove"})
     */
    private $agence;

    public function __construct()
    {
        $this->transactionDepots = new ArrayCollection();
        $this->transactionRetraits = new ArrayCollection();
        $this->depots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getSolde(): ?float
    {
        return $this->solde;
    }

    public function setSolde(float $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionDepots(): Collection
    {
        return $this->transactionDepots;
    }

    public function addTransactionDepot(Transaction $transactionDepot): self
    {
        if (!$this->transactionDepots->contains($transactionDepot)) {
            $this->transactionDepots[] = $transactionDepot;
            $transactionDepot->setCompte($this);
        }

        return $this;
    }

    public function removeTransactionDepot(Transaction $transactionDepot): self
    {
        if ($this->transactionDepots->removeElement($transactionDepot)) {
            // set the owning side to null (unless already changed)
            if ($transactionDepot->getCompte() === $this) {
                $transactionDepot->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionRetraits(): Collection
    {
        return $this->transactionRetraits;
    }

    public function addTransactionRetrait(Transaction $transactionRetrait): self
    {
        if (!$this->transactionRetraits->contains($transactionRetrait)) {
            $this->transactionRetraits[] = $transactionRetrait;
            $transactionRetrait->setCompte($this);
        }

        return $this;
    }

    public function removeTransactionRetrait(Transaction $transactionRetrait): self
    {
        if ($this->transactionRetraits->removeElement($transactionRetrait)) {
            // set the owning side to null (unless already changed)
            if ($transactionRetrait->getCompte() === $this) {
                $transactionRetrait->setCompte(null);
            }
        }

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
            $depot->setCompte($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getCompte() === $this) {
                $depot->setCompte(null);
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

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }
}
