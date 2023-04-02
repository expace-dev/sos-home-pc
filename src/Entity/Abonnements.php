<?php

namespace App\Entity;

use App\Repository\AbonnementsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementsRepository::class)]
class Abonnements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'abonnements', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $client = null;

    #[ORM\Column(length: 255)]
    private ?string $formule = null;

    #[ORM\Column]
    private ?bool $actif = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $paymentIntent = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subscribeId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $plan = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ExpiratedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Users
    {
        return $this->client;
    }

    public function setClient(Users $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getFormule(): ?string
    {
        return $this->formule;
    }

    public function setFormule(string $formule): self
    {
        $this->formule = $formule;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getPaymentIntent(): ?string
    {
        return $this->paymentIntent;
    }

    public function setPaymentIntent(?string $paymentIntent): self
    {
        $this->paymentIntent = $paymentIntent;

        return $this;
    }

    public function getSubscribeId(): ?string
    {
        return $this->subscribeId;
    }

    public function setSubscribeId(?string $subscribeId): self
    {
        $this->subscribeId = $subscribeId;

        return $this;
    }

    public function getPlan(): ?string
    {
        return $this->plan;
    }

    public function setPlan(?string $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getExpiratedAt(): ?string
    {
        return $this->ExpiratedAt;
    }

    public function setExpiratedAt(?string $ExpiratedAt): self
    {
        $this->ExpiratedAt = $ExpiratedAt;

        return $this;
    }

}
