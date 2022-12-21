<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 *
 * @ORM\Table(name="group", indexes={@ORM\Index(name="IDX_6DC044C5C5714CB6", columns={"o_tourney_id"})})
 * @ORM\Entity
 */
class Group
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
     * @var \Tourney
     *
     * @ORM\ManyToOne(targetEntity="Tourney")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="o_tourney_id", referencedColumnName="id")
     * })
     */
    private $oTourney;


}
