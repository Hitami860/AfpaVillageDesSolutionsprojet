<?php

namespace App\Entity;

use App\Repository\InterventionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionsRepository::class)]
class Interventions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'interventions', cascade:["remove"])]
    private ?Partner $partner = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $enddate = null;

    #[ORM\Column(nullable: true)]
    private ?int $places = null;

    /**
     * @var Collection<int, RegistrationInterventions>
     */
    #[ORM\OneToMany(targetEntity: RegistrationInterventions::class, mappedBy: 'interventions', orphanRemoval: true)]
    private Collection $registrationInterventions;

    public function __construct()
    {
        $this->registrationInterventions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPartner(): ?Partner
    {
        return $this->partner;
    }

    public function setPartner(?Partner $partner): static
    {
        $this->partner = $partner;

        return $this;
    }

    public function getEnddate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEnddate(?\DateTimeInterface $enddate): static
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(?int $places): static
    {
        $this->places = $places;

        return $this;
    }

    /**
     * @return Collection<int, RegistrationInterventions>
     */
    public function getRegistrationInterventions(): Collection
    {
        return $this->registrationInterventions;
    }

    public function addRegistrationIntervention(RegistrationInterventions $registrationIntervention): static
    {
        if (!$this->registrationInterventions->contains($registrationIntervention)) {
            $this->registrationInterventions->add($registrationIntervention);
            $registrationIntervention->setInterventions($this);
        }

        return $this;
    }

    public function removeRegistrationIntervention(RegistrationInterventions $registrationIntervention): static
    {
        if ($this->registrationInterventions->removeElement($registrationIntervention)) {
            // set the owning side to null (unless already changed)
            if ($registrationIntervention->getInterventions() === $this) {
                $registrationIntervention->setInterventions(null);
            }
        }

        return $this;
    }
}
