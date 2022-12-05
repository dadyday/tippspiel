<?php

namespace App\Entity;

abstract class BaseEntity
{
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
            return $this->$func($value);
        }
        return $this->$name = $value;
    }

    function __call($name, $aArg) {
        $what = substr($name, 0, 3);
        $var = lcfirst(substr($name, 3));
        switch ($what) {
            case 'get': return $this->$var;
            case 'set': return $this->$var = $aArg[0];
        }
        throw new \Exception("unknown method '$name'");
    }
}
