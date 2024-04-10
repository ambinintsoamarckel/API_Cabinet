<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MedicamentsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;

#[ORM\Entity(repositoryClass: MedicamentsRepository::class)]
#[ApiResource( 
    normalizationContext: ['groups'=>['getcollection:med']],
    denormalizationContext: ['groups'=>['post:med','post:med2']],
    openapiContext:['security' => [['JWT'=> []]]])]
#[Get(uriTemplate:'medicaments/{id}')]
#[Post(uriTemplate:'medicaments')]
#[Delete(uriTemplate:'medicaments/{id}')]
#[GetCollection(paginationItemsPerPage: 10, uriTemplate:'medicaments')]
#[Patch(uriTemplate:'medicaments/{id}')]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'DESC'])]
class Medicaments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getcollection:med'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getcollection:med','post:med'])]
    private ?string $nom = null;

    #[ORM\Column(length: 10)]
    #[Groups(['getcollection:med','post:med'])]
    private ?string $posologie = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getcollection:med','post:med'])]
    private ?string $duree = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['getcollection:med','post:med'])]
    private ?string $note = null;

    #[ORM\ManyToOne(inversedBy: 'medicaments')]
    #[Groups(['getcollection:med','post:med2'])]
    private ?Consultation $consultation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPosologie(): ?string
    {
        return $this->posologie;
    }

    public function setPosologie(string $posologie): static
    {
        $this->posologie = $posologie;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): static
    {
        $this->consultation = $consultation;

        return $this;
    }
}
