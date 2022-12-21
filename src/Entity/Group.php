<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
#[ApiResource]
class Group extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 10, nullable: false)]
    protected ?string $short = null;

    #[ORM\Column(length: 40, nullable: true)]
    protected ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'aGroup')]
    ##[ORM\JoinColumn(nullable: false)]
    protected ?Tourney $oTourney = null;

    # #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    # protected array $aTeam = [];

    #[ORM\OneToMany(mappedBy: 'oGroup', targetEntity: Battle::class)]
    protected Collection $aBattle;

    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'aGroup')]
    private Collection $aTeam;

    # #[ORM\ManyToMany(targetEntity: Team::class)]
    # protected Collection $teams;

    public function __construct()
    {
        $this->aBattle = new ArrayCollection();
        $this->aTeam = new ArrayCollection();
    }

    /**
     * @return Collection<int, Team>
     */
    public function getATeam(): Collection
    {
        return $this->aTeam;
    }

    public function addATeam(Team $aTeam): self
    {
        if (!$this->aTeam->contains($aTeam)) {
            $this->aTeam->add($aTeam);
        }

        return $this;
    }

    public function removeATeam(Team $aTeam): self
    {
        $this->aTeam->removeElement($aTeam);

        return $this;
    }
}
