<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DayRepository::class)]
#[ApiResource]
class Day extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 10)]
    protected ?string $short = null;

    #[ORM\Column(length: 40)]
    protected ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'oDay', targetEntity: Battle::class)]
    protected Collection $aBattle;

    #[ORM\ManyToOne(inversedBy: 'aDay')]
    ##[ORM\JoinColumn(nullable: false)]
    protected ?Tourney $oTourney = null;


    public function __construct()
    {
        $this->aBattle = new ArrayCollection();
    }
}
