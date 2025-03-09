<?php 

namespace App\Interfaces;

interface ProductValidationInterface 
{
    public function validate(array $data): void;
}