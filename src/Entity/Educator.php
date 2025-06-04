<?php

namespace App\Entity;

use App\Repository\EducatorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducatorRepository::class)]
class Educator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'educators')]
    private ?Team $team = null;

    /**
     * @var Collection<int, EducatorPresence>
     */
    #[ORM\OneToMany(targetEntity: EducatorPresence::class, mappedBy: 'educator')]
    private Collection $educatorPresences;

    public function __construct()
    {
        $this->educatorPresences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): static
    {
        $this->user_id = $user_id;

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
            $educatorPresence->setEducator($this);
        }

        return $this;
    }

    public function removeEducatorPresence(EducatorPresence $educatorPresence): static
    {
        if ($this->educatorPresences->removeElement($educatorPresence)) {
            // set the owning side to null (unless already changed)
            if ($educatorPresence->getEducator() === $this) {
                $educatorPresence->setEducator(null);
            }
        }

        return $this;
    }
}
