<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Battle
 *
 * @ORM\Table(name="battle", indexes={@ORM\Index(name="IDX_1399173417414A5", columns={"o_day_id"}), @ORM\Index(name="IDX_13991734FE31060F", columns={"o_team2_id"}), @ORM\Index(name="IDX_13991734F5FBBF02", columns={"o_group_id"}), @ORM\Index(name="IDX_13991734C5714CB6", columns={"o_tourney_id"}), @ORM\Index(name="IDX_13991734EC84A9E1", columns={"o_team1_id"})})
 * @ORM\Entity
 */
class Battle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     * @var \Group
     *
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="o_group_id", referencedColumnName="id")
     * })
     */
    private $oGroup;

    /**
     * @var \Tourney
     *
     * @ORM\ManyToOne(targetEntity="Tourney")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="o_tourney_id", referencedColumnName="id")
     * })
     */
    private $oTourney;

    /**
     * @var \Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="o_team2_id", referencedColumnName="id")
     * })
     */
    private $oTeam2;

    /**
     * @var \Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="o_team1_id", referencedColumnName="id")
     * })
     */
    private $oTeam1;

    /**
     * @var \Day
     *
     * @ORM\ManyToOne(targetEntity="Day")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="o_day_id", referencedColumnName="id")
     * })
     */
    private $oDay;


}
