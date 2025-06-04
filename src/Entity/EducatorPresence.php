<?php

namespace App\Entity;

use App\Repository\EducatorPresenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducatorPresenceRepository::class)]
class EducatorPresence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'educatorPresences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Date $date = null;

    #[ORM\ManyToOne(inversedBy: 'educatorPresences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Educator $educator = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $entrance_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $exit_hour = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_present = null;

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

    public function getEducator(): ?Educator
    {
        return $this->educator;
    }

    public function setEducator(?Educator $educator): static
    {
        $this->educator = $educator;

        return $this;
    }

    public function getEntranceHour(): ?\DateTime
    {
        return $this->entrance_hour;
    }

    public function setEntranceHour(\DateTime $entrance_hour): static
    {
        $this->entrance_hour = $entrance_hour;

        return $this;
    }

    public function getExitHour(): ?\DateTime
    {
        return $this->exit_hour;
    }

    public function setExitHour(\DateTime $exit_hour): static
    {
        $this->exit_hour = $exit_hour;

        return $this;
    }

    public function isPresent(): ?bool
    {
        return $this->is_present;
    }

    public function setIsPresent(?bool $is_present): static
    {
        $this->is_present = $is_present;

        return $this;
    }
}
