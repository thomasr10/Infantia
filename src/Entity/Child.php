<?php

namespace App\Entity;

use App\Repository\ChildRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;


#[ORM\Entity(repositoryClass: ChildRepository::class)]
class Child
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $first_name = null;

    #[ORM\Column(length: 100)]
    private ?string $last_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birth_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $entrance_date = null;

    #[ORM\Column]
    private ?int $household_income = null;

    /**
     * @var Collection<int, Allergy>
     */
    #[ORM\ManyToMany(targetEntity: Allergy::class, inversedBy: 'children')]
    private Collection $allergy;

    /**
     * @var Collection<int, Representative>
     */
    #[ORM\ManyToMany(targetEntity: Representative::class, inversedBy: 'children')]
    private Collection $representative;

    /**
     * @var Collection<int, TrustedPerson>
     */
    #[ORM\ManyToMany(targetEntity: TrustedPerson::class, inversedBy: 'children')]
    private Collection $trusted_person;

    /**
     * @var Collection<int, ChildPresence>
     */
    #[ORM\OneToMany(targetEntity: ChildPresence::class, mappedBy: 'child')]
    private Collection $childPresences;

    #[ORM\Column(length: 25)]
    private ?string $gender = null;

    #[ORM\ManyToOne(targetEntity: Team::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    public function __construct()
    {
        $this->allergy = new ArrayCollection();
        $this->representative = new ArrayCollection();
        $this->trusted_person = new ArrayCollection();
        $this->childPresences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): static
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getEntranceDate(): ?\DateTimeInterface
    {
        return $this->entrance_date;
    }

    public function setEntranceDate(\DateTimeInterface $entrance_date): static
    {
        $this->entrance_date = $entrance_date;

        return $this;
    }

    public function getHouseholdIncome(): ?int
    {
        return $this->household_income;
    }

    public function setHouseholdIncome(int $household_income): static
    {
        $this->household_income = $household_income;

        return $this;
    }

    /**
     * @return Collection<int, Allergy>
     */
    public function getAllergy(): Collection
    {
        return $this->allergy;
    }

    public function addAllergy(Allergy $allergy): static
    {
        if (!$this->allergy->contains($allergy)) {
            $this->allergy->add($allergy);
        }

        return $this;
    }

    public function removeAllergy(Allergy $allergy): static
    {
        $this->allergy->removeElement($allergy);

        return $this;
    }

    /**
     * @return Collection<int, Representative>
     */
    public function getRepresentative(): Collection
    {
        return $this->representative;
    }

    public function addRepresentative(Representative $representative): static
    {
        if (!$this->representative->contains($representative)) {
            $this->representative->add($representative);
        }

        return $this;
    }

    public function removeRepresentative(Representative $representative): static
    {
        $this->representative->removeElement($representative);

        return $this;
    }

    /**
     * @return Collection<int, TrustedPerson>
     */
    public function getTrustedPerson(): Collection
    {
        return $this->trusted_person;
    }

    public function addTrustedPerson(TrustedPerson $trustedPerson): static
    {
        if (!$this->trusted_person->contains($trustedPerson)) {
            $this->trusted_person->add($trustedPerson);
        }

        return $this;
    }

    public function removeTrustedPerson(TrustedPerson $trustedPerson): static
    {
        $this->trusted_person->removeElement($trustedPerson);

        return $this;
    }

    /**
     * @return Collection<int, ChildPresence>
     */
    public function getChildPresences(): Collection
    {
        return $this->childPresences;
    }

    public function addChildPresence(ChildPresence $childPresence): static
    {
        if (!$this->childPresences->contains($childPresence)) {
            $this->childPresences->add($childPresence);
            $childPresence->setChild($this);
        }

        return $this;
    }

    public function removeChildPresence(ChildPresence $childPresence): static
    {
        if ($this->childPresences->removeElement($childPresence)) {
            // set the owning side to null (unless already changed)
            if ($childPresence->getChild() === $this) {
                $childPresence->setChild(null);
            }
        }

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }
}
