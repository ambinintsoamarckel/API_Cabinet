<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlanningRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity(repositoryClass: PlanningRepository::class)]
#[ApiResource( 
    normalizationContext: ['groups'=>['getcollection:pla']],
    denormalizationContext: ['groups'=>['post:pla']],
    openapiContext:['security' => [['JWT'=> []]]])]
#[Get()]
#[Post()]
#[Delete()]
#[GetCollection(paginationItemsPerPage: 10)]
#[Patch()]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getcollection:pla'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,unique: true)]
    #[Groups(['getcollection:pla','post:pla'])]
    private ?\DateTimeInterface $debut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,unique: true)]
    #[Groups(['getcollection:pla','post:pla'])]
    private ?\DateTimeInterface $fin = null;

    #[ORM\Column]
    #[Groups(['getcollection:pla','post:pla'])]
    private ?int $limite = null;

    #[ORM\OneToMany(targetEntity: Rendezvous::class, mappedBy: 'planning')]
    #[Groups(['getcollection:pla'])]
    private Collection $rendezvous;

    public function __construct()
    {
        $this->rendezvous = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): static
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): static
    {
        $this->fin = $fin;

        return $this;
    }

    public function getLimite(): ?int
    {
        return $this->limite;
    }

    public function setLimite(int $limite): static
    {
        $this->limite = $limite;

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
            $rendezvou->setPlanning($this);
        }

        return $this;
    }

    public function removeRendezvou(Rendezvous $rendezvou): static
    {
        if ($this->rendezvous->removeElement($rendezvou)) {
            // set the owning side to null (unless already changed)
            if ($rendezvou->getPlanning() === $this) {
                $rendezvou->setPlanning(null);
            }
        }

        return $this;
    }
}
