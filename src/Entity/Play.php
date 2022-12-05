<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlayRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayRepository::class)]
#[ApiResource]
class Play extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'plays')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Team $team1 = null;

    #[ORM\ManyToOne(inversedBy: 'plays')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Team $team2 = null;

    #[ORM\Column(length: 40)]
    protected ?string $name = null;
}
