<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity;

class DemoFixture extends Fixture
{
    public $aData = [
        'Team' => [
            ['country', 'name'],
            ['QA', 'Katar'],
            ['EQ', 'Ecuador'],
            ['SE', 'Senegal'],
            ['NL', 'Niederlande'],
        ],
        'Tourney' => [
            'short' => 'WM22',
            'name' => 'WM der Männer 2022 Katar',
        ],
        'Day' => [
            ['short', 'name', 'oTourney' => 'byShort(WM22)'],
            ['1', 'Gruppenphase 1', 'WM22'],
            ['2', 'Gruppenphase 2'],
            ['3', 'Gruppenphase 3'],
            ['1/8', 'Achtenfinale'],
            ['1/4', 'Viertelfinale'],
            ['1/2', 'Halbfinale'],
            ['1/1', 'Finale'],
        ],
        'Group' => [
            ['short', 'aTeam' => 'byCountry', 'oTourney' => 'byShort(WM22)'],
            ['A', ['QA', 'EQ', 'SE', 'NL']],
            ['B'],
            ['C'],
            ['D'],
            ['E'],
            ['F'],
            ['G'],
            ['H'],
        ],
        'Battle' => [
            ['date', 'time', 'oDay' => 'byShort()', 'oTeam1' => 'byCountry()', 'oTeam2' => 'byCountry()', 'oGroup' => 'byShort()', 'name', 'oTourney' => 'byShort(WM22)'],
            ['2022-11-20', '17:00', '1', 'QA', 'EQ', 'A'],
            ['2022-11-21', '17:00', '1', 'SE', 'NL', 'A', 'Senegal vs. Niederlande'],
        ],
    //*/
/*
"aDay" => array:15 [                        
  "fieldName" => "aDay"                     
  "mappedBy" => "oTourney"                  
  "targetEntity" => "App\Entity\Day"        
  "cascade" => []                           
  "orphanRemoval" => true                   
  "fetch" => 2                              
  "type" => 4                               
  "inversedBy" => null                      
  "isOwningSide" => false                   
  "sourceEntity" => "App\Entity\Tourney"    
  "isCascadeRemove" => true                 
  "isCascadePersist" => false               
  "isCascadeRefresh" => false               
  "isCascadeMerge" => false                 
  "isCascadeDetach" => false                
]                                           
"oTourney" => array:19 [                          
  "fieldName" => "oTourney"                       
  "joinColumns" => array:1 [                      
    0 => array:2 [                                
      "name" => "o_tourney_id"                    
      "referencedColumnName" => "id"              
    ]                                             
  ]                                               
  "cascade" => []                                 
  "inversedBy" => "aDay"                          
  "targetEntity" => "App\Entity\Tourney"          
  "fetch" => 2                                    
  "type" => 2                                     
  "mappedBy" => null                              
  "isOwningSide" => true                          
  "sourceEntity" => "App\Entity\Day"              
  "isCascadeRemove" => false                      
  "isCascadePersist" => false                     
  "isCascadeRefresh" => false                     
  "isCascadeMerge" => false                       
  "isCascadeDetach" => false                      
  "sourceToTargetKeyColumns" => array:1 [         
    "o_tourney_id" => "id"                        
  ]                                               
  "joinColumnFieldNames" => array:1 [             
    "o_tourney_id" => "o_tourney_id"              
  ]                                               
  "targetToSourceKeyColumns" => array:1 [         
    "id" => "o_tourney_id"                        
  ]                                               
  "orphanRemoval" => false                        
]                                                 */
    ];

    protected function loadFromArray(ObjectManager $oEm, $aData) {
        $propertySetter = function ($oEntity, $prop, $value, $default = null) use (&$entity, &$oMeta) {
            #dump([$oEntity, $prop, $value, $default]);
            $func = null;
            if (preg_match('~^(\w+)(?:\((.*)\))$~', $default ?? '', $aMatch)) {
                $func = $aMatch[1] ?? null; 
                $default = $aMatch[2] ?: null;
            }
            
            if ($oMeta->hasAssociation($prop)) {
                $target = $oMeta->getAssociationTargetClass($prop);
                
                if ($oMeta->isSingleValuedAssociation($prop)) {
                    $value = call_user_func("$target::$func", $value ?? $default);
                    #dump([$prop, "$target::$func", $value]);
                    if (!is_null($value)) $oEntity->$prop = $value;
                }
                else if ($oMeta->isCollectionValuedAssociation($prop)) {
                    #foreach
                    dump($value);
                    #$value = call_user_func("$target::$func", $value ?? $default);
                    
                    if (!is_null($value)) $oEntity->$prop = new ArrayCollection($value);
                }
            }
            else if ($oMeta->hasField($prop)) {
                $type = $oMeta->getTypeOfField($prop);
                $value = $value ?? $default;
                switch ($type) {
                    case 'string':
                        $value = (string) $value; break;
                    case 'date': case 'time':
                        $value = new \DateTime($value); break;
                    case 'simple_array':
                        $value = (array) $value; break;
                    default:
                        dump([$prop, $value, $type]);
                }
                
                if (!is_null($value)) $oMeta->setFieldValue($oEntity, $prop, $value);
            }
            else throw new \Exception("entity '$entity' property '$prop' not found");
        };

        $i = 0;
        foreach ($aData as $entity => $aItem) {
            # prepare entity class
            $class = 'App\\Entity\\'.$entity;
            if (!class_exists($class)) throw new \Exception("entity '$entity' class not found");
            $oMeta = $oEm->getClassMetadata($class);
            #dump($oMeta->associationMappings); continue;
            #dump($oMeta->fieldMappings); continue;
            
            # no scalar values allowed 
            if (!is_iterable($aItem)) throw new \Exception("data entry '$i' is not iterable");
            
            # handle single prop array as list
            if (!array_is_list($aItem)) $aItem = [$aItem];
            
            # decide if csv or object style is given
            if (count($aItem) > 1 && array_is_list($aItem[1])) {
                # csv style
                $aHead = array_shift($aItem);
                $aProp = [];
                # normalize head
                foreach ($aHead as $prop => $func) {
                    if (is_integer($prop)) { $prop = $func; $func = null; }
                    $aProp[] = [$prop, $func];
                }
                # iterate entities
                foreach ($aItem as $aValue) {
                    $oEntity = new $class;
                    # iterate properties
                    foreach ($aProp as $f => [$prop, $func]) {
                        $propertySetter($oEntity, $prop, $aValue[$f] ?? null, $func);
                    }
                    $oEntity->save();
                }
            }
            else {
                # iterate entities
                foreach ($aItem as $aValue) {
                    $oEntity = new $class;
                    # iterate properties
                    foreach ($aValue as $prop => $value) {
                        $propertySetter($oEntity, $prop, $value);
                    }
                    $oEntity->save();
                }
            };
            $oEm->flush();
            $i++;
        }
    }

    public function load(ObjectManager $oEm): void
    {
        Entity\BaseEntity::$oEm = $oEm;
        $this->loadFromArray($oEm, $this->aData);
    }
    
    public function xx_load(ObjectManager $oEm): void
    {
        Entity\BaseEntity::$oEm = $oEm;
        
        Entity\Team::create([
            'country' => 'QA',
            'name' => 'Katar',
        ]);
        Entity\Team::create([
            'country' => 'FR',
            'name' => 'Frankreich',
        ]);
        $oEm->flush();
            
        $oTourney = Entity\Tourney::create();
        $oTourney
            ->setName('WM der Männer 2022 Qatar')
            ->addGroup(
                $oGroup = Entity\Group::create(['name' => 'Gruppe A'])
            )
            ->addDay(
                $oDay = Entity\Battle::create(['name' => 'Spieltag 1'])
            )
            ->addBattle(
                $oBattle = Entity\Battle::create([
                    'name' => 'Gruppe A Spieltag 1',
                    'oTeam1' => Entity\Team::byCountry('QA'),
                    'oTeam2' => Entity\Team::byCountry('FR'),
                ])
                ->setGroup($oGroup)
                ->setDay($oDay)
            )
        ; //*/
        dump($oTourney);

        $oEm->flush();
    }
}
