<?php

namespace App\Entity;

use App\Repository\CitationStagiaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CitationStagiaireRepository::class)]
class CitationStagiaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $job = null;

    #[ORM\Column(length: 255)]
    private ?string $citation = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $auteur = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getCitation(): ?string
    {
        return $this->citation;
    }

    public function setCitation(string $citation): static
    {
        $this->citation = $citation;

        return $this;
    }

    public function getAuteur(): ?Users
    {
        return $this->auteur;
    }

    public function setAuteur(Users $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

}
