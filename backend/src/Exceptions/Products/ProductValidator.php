<?php 

namespace App\Validators\Products;

use InvalidArgumentException;

class ProductValidator 
{
    
    public function validate(string $name, int $price, int $stock): void
    {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("O nome do produto não pode estar vazio.");
        }

        if ($price <= 0) {
            throw new InvalidArgumentException("O preço deve ser maior que zero.");
        }

        if ($stock < 0) {
            throw new InvalidArgumentException("O estoque não pode ser negativo.");
        }
    }
}