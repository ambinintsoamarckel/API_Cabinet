<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ApiResource( 
    normalizationContext: ['groups'=>['getcollection:Pat']],
    denormalizationContext: ['groups'=>['post:pat']],
    openapiContext:['security' => [['JWT'=> []]]])]
#[Get()]
#[Post()]
#[Delete()]
#[GetCollection(paginationItemsPerPage: 10)]
#[Patch()]
/* #[ApiFilter(SearchFilter::class, properties:['vendeur'=>'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['datecom' => 'DESC'])] */


class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getcollection:Pat','post:pat'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getcollection:Pat','post:pat'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getcollection:Pat','post:pat'])]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['getcollection:Pat','post:pat'])]
    private ?\DateTimeInterface $dateDeNaissance = null;

    #[ORM\Column(length: 10,unique: true)]
    #[Groups(['getcollection:Pat','post:pat'])]
    private ?string $telephone = null;

    #[ORM\Column]
    #[Groups(['getcollection:Pat','post:pat'])]
    private ?bool $sexe = null;

    #[ORM\OneToMany(targetEntity: Rendezvous::class, mappedBy: 'patient')]
    #[Groups(['getcollection:Pat'])]
    private Collection $rendezvous;

    #[ORM\OneToMany(targetEntity: Consultation::class, mappedBy: 'patient')]
    #[Groups(['getcollection:Pat'])]
    private Collection $consultations;

    public function __construct()
    {
        $this->rendezvous = new ArrayCollection();
        $this->consultations = new ArrayCollection();
    }



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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $dateDeNaissance): static
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function isSexe(): ?bool
    {
        return $this->sexe;
    }

    public function setSexe(bool $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * @return Collection<int, Rendezvous>
     */
    public function getRendezvous(): Collection
    {
        return $this->rendezvous;
    }

    public function addRendezvou(Rendezvous $rendezvou): static
    {
        if (!$this->rendezvous->contains($rendezvou)) {
            $this->rendezvous->add($rendezvou);
            $rendezvou->setPatient($this);
        }

        return $this;
    }

    public function removeRendezvou(Rendezvous $rendezvou): static
    {
        if ($this->rendezvous->removeElement($rendezvou)) {
            // set the owning side to null (unless already changed)
            if ($rendezvou->getPatient() === $this) {
                $rendezvou->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): static
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations->add($consultation);
            $consultation->setPatient($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): static
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getPatient() === $this) {
                $consultation->setPatient(null);
            }
        }

        return $this;
    }


}
