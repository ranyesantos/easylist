<?php 

namespace App\Validators\Products;

use InvalidArgumentException;

class PriceValidator
{
    
    public function validate(array $data): void
    {
        if (!isset($data['price']) || !is_numeric($data['price']) || $data['price'] <= 0) {
            throw new InvalidArgumentException("O preço deve ser maior que zero.");
        }
    }
}