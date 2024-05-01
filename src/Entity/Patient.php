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
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
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
#[ApiFilter(OrderFilter::class, properties: ['id' => 'DESC'])]
#[ApiFilter(SearchFilter::class, properties:['nom'=>'partial','telephone'=>'partial','prenom'=>'partial'])]
/*#[ApiFilter(OrderFilter::class, properties: ['datecom' => 'DESC'])] */


class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getcollection:Pat','post:pat','getcollection:cst'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getcollection:Pat','post:pat','getcollection:cst'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getcollection:Pat','post:pat','getcollection:cst'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 10,unique: true)]
    #[Groups(['getcollection:Pat','post:pat','getcollection:cst'])]
    private ?string $telephone = null;

    #[ORM\Column]
    #[Groups(['getcollection:Pat','post:pat','getcollection:cst'])]
    private ?bool $sexe = null;

    #[ORM\OneToMany(targetEntity: Rendezvous::class, mappedBy: 'patient')]
    private Collection $rendezvous;

    #[ORM\OneToMany(targetEntity: Consultation::class, mappedBy: 'patient')]
    private Collection $consultations;

    #[ORM\Column]
    #[Groups(['getcollection:Pat','post:pat'])]
    private ?int $age = null;

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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }


}
