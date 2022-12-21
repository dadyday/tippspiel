<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TourneyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TourneyRepository::class)]
#[ApiResource]
class Tourney extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 10)]
    protected ?string $short = null;

    #[ORM\Column(length: 120)]
    protected ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'oTourney', targetEntity: Group::class)]
    protected Collection $aGroup;

    #[ORM\OneToMany(mappedBy: 'oTourney', targetEntity: Battle::class, orphanRemoval: true)]
    protected Collection $aBattle;

    #[ORM\OneToMany(mappedBy: 'oTourney', targetEntity: Day::class, orphanRemoval: true)]
    protected Collection $aDay;


    public function __construct()
    {
        $this->aGroup = new ArrayCollection();
        $this->aBattle = new ArrayCollection();
        $this->aDay = new ArrayCollection();
    }
}
