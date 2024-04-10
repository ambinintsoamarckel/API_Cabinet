<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
#[ApiResource( 
    normalizationContext: ['groups'=>['getcollection:cst']],
    denormalizationContext: ['groups'=>['post:cst','post:med']],
    openapiContext:['security' => [['JWT'=> []]]])]
#[Get()]
#[Post()]
#[Delete()]
#[GetCollection(paginationItemsPerPage: 10)]
#[Patch()]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getcollection:cst'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,unique: true)]
    #[Groups(['getcollection:cst','post:cst'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['getcollection:cst','post:cst'])]
    private ?Patient $patient = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['getcollection:cst','post:cst'])]
    private ?string $motif = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getcollection:cst','post:cst'])]
    private ?string $diagnostic = null;

    #[ORM\OneToMany(targetEntity: Medicaments::class, mappedBy: 'consultation', cascade: ['all'])]
    #[Groups(['getcollection:cst','post:cst'])]
    private Collection $medicaments;

    #[ORM\Column]
    #[Groups(['getcollection:cst','post:cst'])]
    private ?int $totalPaye = null;

    public function __construct()
    {
        $this->medicaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getDiagnostic(): ?string
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(string $diagnostic): static
    {
        $this->diagnostic = $diagnostic;

        return $this;
    }

    /**
     * @return Collection<int, Medicaments>
     */
    public function getMedicaments(): Collection
    {
        return $this->medicaments;
    }

    public function addMedicament(Medicaments $medicament): static
    {
        if (!$this->medicaments->contains($medicament)) {
            $this->medicaments->add($medicament);
            $medicament->setConsultation($this);
        }

        return $this;
    }

    public function removeMedicament(Medicaments $medicament): static
    {
        if ($this->medicaments->removeElement($medicament)) {
            // set the owning side to null (unless already changed)
            if ($medicament->getConsultation() === $this) {
                $medicament->setConsultation(null);
            }
        }

        return $this;
    }

    public function getTotalPaye(): ?int
    {
        return $this->totalPaye;
    }

    public function setTotalPaye(int $totalPaye): static
    {
        $this->totalPaye = $totalPaye;

        return $this;
    }
}