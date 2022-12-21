<?php
namespace App;

use Doctrine\ORM\EntityManager as EM;

#[AsDecorator(decorates: Em::class)]
class EntityManager {

	static $oInst;
	private $oEm;

	public function __construct(#[MapDecorated] $oEm) {
		$this->oEm = $oEm;
		static::$oInst = $this;
	}
}