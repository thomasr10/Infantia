<?php

namespace App\Entity;

use App\Repository\ScheduledActivityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduledActivityRepository::class)]
class ScheduledActivity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'scheduledActivities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Date $date = null;

    #[ORM\ManyToOne(inversedBy: 'scheduledActivities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    #[ORM\ManyToOne(inversedBy: 'scheduledActivities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Activity $activity = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $starting_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $ending_hour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?Date
    {
        return $this->date;
    }

    public function setDate(?Date $date): static
    {
        $this->date = $date;

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

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): static
    {
        $this->activity = $activity;

        return $this;
    }

    public function getStartingHour(): ?\DateTime
    {
        return $this->starting_hour;
    }

    public function setStartingHour(\DateTime $starting_hour): static
    {
        $this->starting_hour = $starting_hour;

        return $this;
    }

    public function getEndingHour(): ?\DateTime
    {
        return $this->ending_hour;
    }

    public function setEndingHour(\DateTime $ending_hour): static
    {
        $this->ending_hour = $ending_hour;

        return $this;
    }
}
