<?php
namespace App;

use Doctrine\ORM\Mapping;


class NamingStrategy implements Mapping\NamingStrategy {

	protected function removePrefix($prop): string {
		if (preg_match('~^[ao]?([A-Z]\w+)$~', $prop, $aMatch)) {
			$prop = $aMatch[1];
		};
		return $prop;
	}
	
	public function classToTableName($class): string {
		return strtolower(basename($class));
	}
	
	public function propertyToColumnName($prop, $class = null): string  {
		return strtolower($prop);
	}
	
	public function referenceColumnName(): string  {
		return 'id';
	}
	
	public function joinColumnName($prop): string  {
		$prop = $this->removePrefix($prop);
		return strtolower($prop).'_ref';
	}
	
	public function joinTableName($srcClass, $trgClass, $prop = null): string  {
		return strtolower($this->classToTableName($srcClass) . '_' . $this->classToTableName($trgClass));
	}
	
	public function joinKeyColumnName($entity, $refColumn = null): string  {
		$refColumn = $refColumn ?: 'ref';
		return strtolower($this->classToTableName($entity)) . '_' . $refColumn;
	}

	public function embeddedFieldToColumnName($prop, $embeddedColumn, $class = null, $embeddedClass = null): string  {
		$prop = $this->removePrefix($prop);
		return strtolower($prop);
	}
}
