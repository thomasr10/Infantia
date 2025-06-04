<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, ScheduledActivity>
     */
    #[ORM\OneToMany(targetEntity: ScheduledActivity::class, mappedBy: 'activity')]
    private Collection $scheduledActivities;

    public function __construct()
    {
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
            $scheduledActivity->setActivity($this);
        }

        return $this;
    }

    public function removeScheduledActivity(ScheduledActivity $scheduledActivity): static
    {
        if ($this->scheduledActivities->removeElement($scheduledActivity)) {
            // set the owning side to null (unless already changed)
            if ($scheduledActivity->getActivity() === $this) {
                $scheduledActivity->setActivity(null);
            }
        }

        return $this;
    }
}
