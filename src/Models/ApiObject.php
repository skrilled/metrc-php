<?php

namespace MetrcApi\Models;

class ApiObject
{

    public function __call($name, $arguments)
    {
        $namePrefix = substr($name, 0, 3);
        $property = substr($name, 3);

        if($namePrefix == 'set') {
            $this->{$property} = $arguments[0];
        } elseif($namePrefix == 'get') {
            return $this->{$property};
        }
    }

}