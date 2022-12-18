<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BattleRepository;
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

    #[ORM\ManyToOne(inversedBy: 'Battle')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tourney $tourney = null;

    #[ORM\ManyToOne(inversedBy: 'Battle')]
    protected Day $oDay;

    #[ORM\ManyToOne(inversedBy: 'Battle')]
    protected ?Group $oGroup = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Team $oTeam1 = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Team $oTeam2 = null;

    public function __toString(): string
    {
        return "$this->name {$this->team1}:{$this->team2}";
    }

}
