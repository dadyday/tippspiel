<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TourneyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TourneyRepository::class)]
#[ApiResource]
class Tourney
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 120)]
    protected ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'tourney', targetEntity: Group::class)]
    protected Collection $aGroup;

    #[ORM\OneToMany(mappedBy: 'tourney', targetEntity: Battle::class, orphanRemoval: true)]
    protected Collection $aBattle;

    public function __construct()
    {
        $this->aGroup = new ArrayCollection();
        $this->aBattle = new ArrayCollection();
    }

    public function addGroup(Group $oGroup): self
    {
        if (!$this->aGroup->contains($oGroup)) {
            $this->aGroup->add($oGroup);
            $oGroup->setTourney($this);
        }

        return $this;
    }

    public function removeGroup(Group $oGroup): self
    {
        if ($this->aGroup->removeElement($oGroup)) {
            // set the owning side to null (unless already changed)
            if ($oGroup->getTourney() === $this) {
                $oGroup->setTourney(null);
            }
        }

        return $this;
    }

    public function addMatch(Battle $oBattle): self
    {
        if (!$this->aBattle->contains($oBattle)) {
            $this->aBattle->add($oBattle);
            $oBattle->setTourney($this);
        }

        return $this;
    }

    public function removeMatch(Battle $oBattle): self
    {
        if ($this->aBattle->removeElement($oBattle)) {
            // set the owning side to null (unless already changed)
            if ($oBattle->getTourney() === $this) {
                $oBattle->setTourney(null);
            }
        }

        return $this;
    }
}
