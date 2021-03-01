<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      collectionOperations={
 *        "get"={
 *               "method"="GET", 
 *               "path"="/admin/transactions",
 *                "security"="(is_granted('ROLE_AdminSysteme'))",
 *                  "security_message"="Acces non autorisé"
 *         },
 *        "get_part_etat"={
 *               "method"="GET", 
 *               "path"="/admin/transactions/part_etat",
 *                "security"="(is_granted('ROLE_AdminSysteme'))",
 *                "normalization_context"={"groups"={"get:partetat"}},
 *                  "security_message"="Acces non autorisé"
 *         },
 *         "post_transaction"={
 *               "method"="POST", 
 *               "path"="/user/transactions",
 *                "security"="(is_granted('ROLE_AdminAgence') or is_granted('ROLE_UserAgence'))",
 *                "denormalization_context"={"groups"={"post:trans","post:client"}},
 *                  "security_message"="Acces non autorisé"
 *         },
 *      },
 *      itemOperations={
 *           "put_transaction_id"={ 
 *               "method"="PUT", 
 *               "path"="/user/transactions/{id}",
 *                 "serializer"=false,
 *                "defaults"={"id"=null},
 *                "requirements"={"id"="\d+"},
 *                "denormalization_context"={"groups"={"post:trans","post:client"}},
 *                "security"="(is_granted('ROLE_AdminAgence') or is_granted('ROLE_UserAgence'))",
 *                  "security_message"="Acces non autorisé",
 *          },
 *          "get",
 *       },
 * )
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get:trans"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="float")
     * @Groups({"post:trans"})
     * @Groups({"get:trans","get:partetat"})
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get:trans","get:com","get:partetat"})
     */
    private $dateAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type="depot";

    /**
     * @ORM\Column(type="float")
     * @Groups({"get:partetat"})
     */
    private $part_etat;

    /**
     * @ORM\Column(type="float")
     */
    private $part_syst;

    /**
     * @ORM\Column(type="float")
     * @Groups({"get:trans","get:com"})
     */
    private $part_depot;

    /**
     * @ORM\Column(type="float")
     * @Groups({"get:trans","get:com"})
     */
    private $part_retrait;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"get:trans","get:com"})
     */
    private $retraitAt;

    /**
     * @ORM\ManyToOne(targetEntity=Compte::class, inversedBy="transactions")
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="retraitClients", cascade={"persist"})
     * @Groups({"post:client","put:trans"})
     */
    private $retraitClient;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="depotClients", cascade={"persist"})
     * @Groups({"post:client"})
     */
    private $depotClient;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="depotAgents")
     */
    private $agentDepot;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="retraitAgents")
     */
    private $agentRetrait;

    /**
     * @ORM\Column(type="float")
     */
    private $frais;



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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPartEtat(): ?float
    {
        return $this->part_etat;
    }

    public function setPartEtat(float $part_etat): self
    {
        $this->part_etat = $part_etat;

        return $this;
    }

    public function getPartSyst(): ?float
    {
        return $this->part_syst;
    }

    public function setPartSyst(float $part_syst): self
    {
        $this->part_syst = $part_syst;

        return $this;
    }

    public function getPartDepot(): ?float
    {
        return $this->part_depot;
    }

    public function setPartDepot(float $part_depot): self
    {
        $this->part_depot = $part_depot;

        return $this;
    }

    public function getPartRetrait(): ?float
    {
        return $this->part_retrait;
    }

    public function setPartRetrait(float $part_retrait): self
    {
        $this->part_retrait = $part_retrait;

        return $this;
    }

    public function getRetraitAt(): ?\DateTimeInterface
    {
        return $this->retraitAt;
    }

    public function setRetraitAt(\DateTimeInterface $retraitAt): self
    {
        $this->retraitAt = $retraitAt;

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

    public function getRetraitClient(): ?Client
    {
        return $this->retraitClient;
    }

    public function setRetraitClient(?Client $retraitClient): self
    {
        $this->retraitClient = $retraitClient;

        return $this;
    }

    public function getDepotClient(): ?Client
    {
        return $this->depotClient;
    }

    public function setDepotClient(?Client $depotClient): self
    {
        $this->depotClient = $depotClient;

        return $this;
    }

    public function getAgentDepot(): ?User
    {
        return $this->agentDepot;
    }

    public function setAgentDepot(?User $agentDepot): self
    {
        $this->agentDepot = $agentDepot;

        return $this;
    }

    public function getAgentRetrait(): ?User
    {
        return $this->agentRetrait;
    }

    public function setAgentRetrait(?User $agentRetrait): self
    {
        $this->agentRetrait = $agentRetrait;

        return $this;
    }

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

        return $this;
    }
 

}
