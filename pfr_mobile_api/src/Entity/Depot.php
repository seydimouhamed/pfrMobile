<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DepotRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     routePrefix="/caissiers",
 *      subresourceOperations= {
 *         "api_users_depots_get_subresource"= {
 *                "security"="(is_granted('ROLE_AdminSysteme') or object.user === user)",
 *                  "security_message"="Acces non autorisé"
 *          },
 *     },
 *      collectionOperations={
 *        "get"={
 *               "method"="GET", 
 *               "path"="/depots",
 *                "security"="(is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé"
 *         },
 *         "post"={
 *               "method"="POST", 
 *               "path"="/depots",
 *                "security"="(is_granted('ROLE_AdminSysteme') or is_granted('ROLE_Caissier'))",
 *                  "security_message"="Acces non autorisé"
 *         },
 *      },
 * )
 * @ORM\Entity(repositoryClass=DepotRepository::class)
 */
class Depot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="depots")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="depots")
     */
    private $compte;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isCanceled= false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateAt(): ?\DateTimeInterface
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTimeInterface $dateAt): self
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getIsCanceled(): ?bool
    {
        return $this->isCanceled;
    }

    public function setIsCanceled(?bool $isCanceled): self
    {
        $this->isCanceled = $isCanceled;

        return $this;
    }
}
