<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setPrimaryTable(array(
   'name' => 'battle',
   'indexes' => 
   array(
   'IDX_1399173417414A5' => 
   array(
    'columns' => 
    array(
    0 => 'o_day_id',
    ),
   ),
   'IDX_13991734FE31060F' => 
   array(
    'columns' => 
    array(
    0 => 'o_team2_id',
    ),
   ),
   'IDX_13991734F5FBBF02' => 
   array(
    'columns' => 
    array(
    0 => 'o_group_id',
    ),
   ),
   'IDX_13991734C5714CB6' => 
   array(
    'columns' => 
    array(
    0 => 'o_tourney_id',
    ),
   ),
   'IDX_13991734EC84A9E1' => 
   array(
    'columns' => 
    array(
    0 => 'o_team1_id',
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
   'fieldName' => 'oGroup',
   'targetEntity' => 'Group',
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
    'name' => 'o_group_id',
    'referencedColumnName' => 'id',
   ),
   ),
   'orphanRemoval' => false,
  ));
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
$metadata->mapOneToOne(array(
   'fieldName' => 'oTeam2',
   'targetEntity' => 'Team',
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
    'name' => 'o_team2_id',
    'referencedColumnName' => 'id',
   ),
   ),
   'orphanRemoval' => false,
  ));
$metadata->mapOneToOne(array(
   'fieldName' => 'oTeam1',
   'targetEntity' => 'Team',
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
    'name' => 'o_team1_id',
    'referencedColumnName' => 'id',
   ),
   ),
   'orphanRemoval' => false,
  ));
$metadata->mapOneToOne(array(
   'fieldName' => 'oDay',
   'targetEntity' => 'Day',
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
    'name' => 'o_day_id',
    'referencedColumnName' => 'id',
   ),
   ),
   'orphanRemoval' => false,
  ));