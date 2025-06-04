<?php

namespace App\Entity;

use App\Repository\DateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DateRepository::class)]
class Date
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column]
    private ?int $week_num = null;

    #[ORM\Column(length: 20)]
    private ?string $day = null;

    #[ORM\Column]
    private ?bool $is_holiday = null;

    /**
     * @var Collection<int, ScheduledActivity>
     */
    #[ORM\OneToMany(targetEntity: ScheduledActivity::class, mappedBy: 'date')]
    private Collection $scheduledActivities;

    /**
     * @var Collection<int, ChildPresence>
     */
    #[ORM\OneToMany(targetEntity: ChildPresence::class, mappedBy: 'date')]
    private Collection $childPresences;

    /**
     * @var Collection<int, EducatorPresence>
     */
    #[ORM\OneToMany(targetEntity: EducatorPresence::class, mappedBy: 'date')]
    private Collection $educatorPresences;

    public function __construct()
    {
        $this->scheduledActivities = new ArrayCollection();
        $this->childPresences = new ArrayCollection();
        $this->educatorPresences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getWeekNum(): ?int
    {
        return $this->week_num;
    }

    public function setWeekNum(int $week_num): static
    {
        $this->week_num = $week_num;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function isHoliday(): ?bool
    {
        return $this->is_holiday;
    }

    public function setIsHoliday(bool $is_holiday): static
    {
        $this->is_holiday = $is_holiday;

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
            $scheduledActivity->setDate($this);
        }

        return $this;
    }

    public function removeScheduledActivity(ScheduledActivity $scheduledActivity): static
    {
        if ($this->scheduledActivities->removeElement($scheduledActivity)) {
            // set the owning side to null (unless already changed)
            if ($scheduledActivity->getDate() === $this) {
                $scheduledActivity->setDate(null);
            }
        }

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
            $childPresence->setDate($this);
        }

        return $this;
    }

    public function removeChildPresence(ChildPresence $childPresence): static
    {
        if ($this->childPresences->removeElement($childPresence)) {
            // set the owning side to null (unless already changed)
            if ($childPresence->getDate() === $this) {
                $childPresence->setDate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EducatorPresence>
     */
    public function getEducatorPresences(): Collection
    {
        return $this->educatorPresences;
    }

    public function addEducatorPresence(EducatorPresence $educatorPresence): static
    {
        if (!$this->educatorPresences->contains($educatorPresence)) {
            $this->educatorPresences->add($educatorPresence);
            $educatorPresence->setDate($this);
        }

        return $this;
    }

    public function removeEducatorPresence(EducatorPresence $educatorPresence): static
    {
        if ($this->educatorPresences->removeElement($educatorPresence)) {
            // set the owning side to null (unless already changed)
            if ($educatorPresence->getDate() === $this) {
                $educatorPresence->setDate(null);
            }
        }

        return $this;
    }
}
