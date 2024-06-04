<?php

namespace App\Entity;

use App\Repository\RendezvousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
#[ORM\Entity(repositoryClass: RendezvousRepository::class)]
#[ApiResource( 
    
    normalizationContext: ['groups'=>['getcollection:rdv']],
    denormalizationContext: ['groups'=>['post:rdv','post:pla','post:pat']],
    openapiContext:['security' => [['JWT'=> []]]])]
#[Get(uriTemplate:'rendezvous/{id}')]
#[Post(uriTemplate:'rendezvous')]
#[Delete(uriTemplate:'rendezvous/{id}')]
#[GetCollection(uriTemplate:'rendezvous')]
#[Patch(uriTemplate:'rendezvous/{id}')]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'DESC'])]
class Rendezvous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getcollection:rdv'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['getcollection:rdv','post:rdv'])]
    private ?bool $statut = null;

    #[ORM\ManyToOne(inversedBy: 'rendezvous', cascade: ['all'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['getcollection:rdv','post:rdv'])]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(inversedBy: 'rendezvous', cascade: ['all'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['getcollection:rdv','post:rdv'])]
    private ?Planning $planning = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getPlanning(): ?Planning
    {
        return $this->planning;
    }

    public function setPlanning(?Planning $planning): static
    {
        $this->planning = $planning;

        return $this;
    }
}
