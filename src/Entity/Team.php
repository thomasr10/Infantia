<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, Educator>
     */
    #[ORM\OneToMany(targetEntity: Educator::class, mappedBy: 'team')]
    private Collection $educators;

    /**
     * @var Collection<int, ScheduledActivity>
     */
    #[ORM\OneToMany(targetEntity: ScheduledActivity::class, mappedBy: 'team')]
    private Collection $scheduledActivities;

    public function __construct()
    {
        $this->educators = new ArrayCollection();
        $this->scheduledActivities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Educator>
     */
    public function getEducators(): Collection
    {
        return $this->educators;
    }

    public function addEducator(Educator $educator): static
    {
        if (!$this->educators->contains($educator)) {
            $this->educators->add($educator);
            $educator->setTeam($this);
        }

        return $this;
    }

    public function removeEducator(Educator $educator): static
    {
        if ($this->educators->removeElement($educator)) {
            // set the owning side to null (unless already changed)
            if ($educator->getTeam() === $this) {
                $educator->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ScheduledActivity>
     */
    public function getScheduledActivities(): Collection
    {
        return $this->scheduledActivities;
    }

    public function addScheduledActivity(ScheduledActivity $scheduledActivity): static
    {
        if (!$this->scheduledActivities->contains($scheduledActivity)) {
            $this->scheduledActivities->add($scheduledActivity);
            $scheduledActivity->setTeam($this);
        }

        return $this;
    }

    public function removeScheduledActivity(ScheduledActivity $scheduledActivity): static
    {
        if ($this->scheduledActivities->removeElement($scheduledActivity)) {
            // set the owning side to null (unless already changed)
            if ($scheduledActivity->getTeam() === $this) {
                $scheduledActivity->setTeam(null);
            }
        }

        return $this;
    }
}
