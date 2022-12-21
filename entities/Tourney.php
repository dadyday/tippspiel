<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tourney
 *
 * @ORM\Table(name="tourney")
 * @ORM\Entity
 */
class Tourney
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
     * @ORM\Column(name="name", type="string", length=120, nullable=false)
     */
    private $name;


}
