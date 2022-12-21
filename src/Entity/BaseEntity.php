<?php

namespace App\Entity;


use App\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;

# https://stackoverflow.com/questions/14684745/get-entitymanager-inside-an-entity
#use Doctrine\Common\Persistence\ObjectManagerAware;
#use Doctrine\Common\Persistence\ObjectManager;
#use Doctrine\Common\Persistence\Mapping\ClassMetadata;


abstract class BaseEntity #implements ObjectManagerAware
{
    static $oEm;
#    public function injectObjectManager(
#        ObjectManager $objectManager,
#        ClassMetadata $classMetadata
#    ) {
#        $this->oEm = $objectManager;
#    }
    
    static function create(iterable $aProp = null) {
        $oInst = new static();
        return $oInst
            ->set($aProp)
            ->save()
        ;
    }

    static function __callStatic($name, $aArg) {
        $oRepo = static::$oEm->getRepository(static::class);
        $what = substr($name, 0, 2);
        $var = lcfirst(substr($name, 2));
        switch ($what) {
            case 'by': 
                return $oRepo->findOneBy([$var => $aArg[0]]);
        };
        throw new \Exception("unknown method '$name'");
    }

    public function set(iterable $aProp = null) {
        foreach ($aProp ?? [] as $var => $value) {
            $this->_setProperty($var, $value);
        }
        return $this;
    }

    public function save() {
        static::$oEm->persist($this);
        return $this;
    }
    
    function __get($name) {
        $func = 'get'.ucfirst($name);
        if (!method_exists($this, $func)) {
            return $this->$func();
        }
        return $this->$name;
    }

    function __set($name, $value) {
        $func = 'set'.ucfirst($name);
        if (!method_exists($this, $func)) {
            $ret = $this->$func($value);
        }
        $ret = $this->$name = $value;
        return $ret;
    }

    function __call($name, $aArg) {
        $what = substr($name, 0, 3);
        $var = substr($name, 3);
        switch ($what) {
            case 'get': return $this->_getProperty($var, ...$aArg);
            case 'set': return $this->_setProperty($var, ...$aArg);
            case 'add': return $this->_addCollectionItem($var, ...$aArg);
            case 'del': return $this->_delCollectionItem($var, ...$aArg);
        }
        throw new \Exception("unknown method '$name'");
    }

    protected function _checkProperty(&$prop) {
        $prop = property_exists($this, 'o'.ucfirst($prop)) ? 'o'.ucfirst($prop) : lcfirst($prop);
        if (!property_exists($this, $prop)) throw new \Exception("unknown property '$prop'");
    }

    protected function _getProperty($prop, $default = null) {
        $this->_checkProperty($prop);
        return $this->$prop ?? $default;
    }

    protected function _setProperty($prop, $value) {
        $this->_checkProperty($prop);
        $this->$prop = $value;
        return $this;
    }

    protected function _getCollectionProperty($coll) {
        if (property_exists($this, $prop = 'a'.ucfirst($coll))) {
            if (is_null($this->$prop)) $this->$prop = new ArrayCollection;
            return $prop;
        }
        throw new \Exception("unknown property '$prop'");
    }

    protected function _addCollectionItem($collection, self $oEntity) {
        $prop = $this->_getCollectionProperty($collection);
        if (!$this->$prop->contains($oEntity)) {
            $this->$prop->add($oEntity);
            //$oEntity->setTourney($this);
        }
        return $this;
    }

    protected function _delCollectionItem($collection, self $oEntity) {
        $prop = $this->_getCollectionProperty($collection);
        $this->$prop->removeElement($oEntity);
        return $this;
    }
}
