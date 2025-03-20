<?php 

namespace App\Validators\Products;

use InvalidArgumentException;

class NameValidator 
{
    
    public function validate(array $data): void
    {
        if (empty(trim($data['name'] ?? ''))) {
            throw new InvalidArgumentException("O nome do produto não pode estar vazio.");
        }
    }
}