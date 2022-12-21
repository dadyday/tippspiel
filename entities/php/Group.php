<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setPrimaryTable(array(
   'name' => 'group',
   'indexes' => 
   array(
   'IDX_6DC044C5C5714CB6' => 
   array(
    'columns' => 
    array(
    0 => 'o_tourney_id',
    ),
   ),
   ),
  ));
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->mapField(array(
   'fieldName' => 'id',
   'columnName' => 'id',
   'type' => 'integer',
   'nullable' => false,
   'options' => 
   array(
   'unsigned' => false,
   ),
   'id' => true,
  ));
$metadata->mapField(array(
   'fieldName' => 'name',
   'columnName' => 'name',
   'type' => 'string',
   'nullable' => false,
   'length' => 40,
   'options' => 
   array(
   'fixed' => false,
   ),
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);
$metadata->mapOneToOne(array(
   'fieldName' => 'oTourney',
   'targetEntity' => 'Tourney',
   'cascade' => 
   array(
   ),
   'fetch' => 2,
   'mappedBy' => NULL,
   'inversedBy' => NULL,
   'joinColumns' => 
   array(
   0 => 
   array(
    'name' => 'o_tourney_id',
    'referencedColumnName' => 'id',
   ),
   ),
   'orphanRemoval' => false,
  ));