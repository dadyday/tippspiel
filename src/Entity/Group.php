<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
#[ApiResource]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'groupings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tourney $tourney = null;

    #[ORM\Column(length: 40)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'grouped', targetEntity: Battle::class)]
    private Collection $Battle;

    public function __construct()
    {
        $this->Battle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTourney(): ?Tourney
    {
        return $this->tourney;
    }

    public function setTourney(?Tourney $tourney): self
    {
        $this->tourney = $tourney;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Battle>
     */
    public function getBattles(): Collection
    {
        return $this->Battle;
    }

    public function addBattle(Battle $Battle): self
    {
        if (!$this->Battle->contains($Battle)) {
            $this->Battle->add($Battle);
            $Battle->setGrouped($this);
        }

        return $this;
    }

    public function removeBattle(Battle $Battle): self
    {
        if ($this->Battle->removeElement($Battle)) {
            // set the owning side to null (unless already changed)
            if ($Battle->getGrouped() === $this) {
                $Battle->setGrouped(null);
            }
        }

        return $this;
    }
}
