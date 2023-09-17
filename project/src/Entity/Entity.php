<?php

namespace Entity;

abstract class Entity
{

    public function hydrate(array $parameters): void
    {
        foreach ($parameters as $key => $value) {
            $method = 'set' . str_replace('_', '', $key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

}