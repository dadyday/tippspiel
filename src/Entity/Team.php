<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[ApiResource]
class Team extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 2)]
    protected ?string $country = null;

    #[ORM\Column(length: 255)]
    protected ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'aTeam')]
    private Collection $aGroup;

    public function __construct()
    {
        $this->aGroup = new ArrayCollection();
    }

    public function __toString(): string
    {
        return "$this->country - $this->name";
    }
}
