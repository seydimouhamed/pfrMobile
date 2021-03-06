<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get:retrait"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post:client","resume"})
     */
    private $nomComplet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"post:client", "put:client"})
     */
    private $cni;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post:client"})
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="retraitClient")
     */
    private $retraitClients;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="depotClient")
     */
    private $depotClients;

  


    public function __construct()
    {
        $this->retraitClients = new ArrayCollection();
        $this->depotClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

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
     * @return Collection|Transaction[]
     */
    public function getRetraitClients(): Collection
    {
        return $this->retraitClients;
    }

    public function addRetraitClient(Transaction $retraitClient): self
    {
        if (!$this->retraitClients->contains($retraitClient)) {
            $this->retraitClients[] = $retraitClient;
            $retraitClient->setRetraitClient($this);
        }

        return $this;
    }

    public function removeRetraitClient(Transaction $retraitClient): self
    {
        if ($this->retraitClients->removeElement($retraitClient)) {
            // set the owning side to null (unless already changed)
            if ($retraitClient->getRetraitClient() === $this) {
                $retraitClient->setRetraitClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getDepotClients(): Collection
    {
        return $this->depotClient;
    }

    public function addDepotClient(Transaction $depotClient): self
    {
        if (!$this->depotClients->contains($depotClient)) {
            $this->depotClients[] = $depotClient;
            $depotClient->setDepotClient($this);
        }

        return $this;
    }

    public function removeDepotClient(Transaction $depotClient): self
    {
        if ($this->depotClients->removeElement($depotClient)) {
            // set the owning side to null (unless already changed)
            if ($depotClient->getDepotClient() === $this) {
                $depotClient->setDepotClient(null);
            }
        }

        return $this;
    }

}
