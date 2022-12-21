<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BattleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BattleRepository::class)]
#[ApiResource]
class Battle extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 40)]
    protected ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'oBattle')]
    ##[ORM\JoinColumn(nullable: false)]
    protected ?Tourney $oTourney = null;

    #[ORM\ManyToOne(inversedBy: 'oBattle')]
    protected ?Day $oDay = null;

    #[ORM\ManyToOne(inversedBy: 'oBattle')]
    protected ?Group $oGroup = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Team $oTeam1 = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Team $oTeam2 = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    protected ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    protected ?\DateTimeInterface $time = null;

    public function __toString(): string
    {
        return "$this->name {$this->team1}:{$this->team2}";
    }
}
