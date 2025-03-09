<?php

namespace App\Config;


class Container 
{
    
    public $instances = [];
    
    public function set($key, $value) 
    {
        $this->instances[$key] = $value;
    }

    public function get(string $name)
    {
        if (isset($this->instances[$name])) {
            return ($this->instances[$name])();
        }

        throw new \Exception("nenhum serviço registrado com o nome: {$name}");
    }
}