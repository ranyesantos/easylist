<?php 

namespace App\Validators\Products;

use InvalidArgumentException;

class StockValidator
{
    public function validate(array $data): void
    {
        if (!isset($data['stock']) || !is_int($data['stock']) || $data['stock'] < 0) {
            throw new InvalidArgumentException("O estoque não pode ser negativo.");
        }
    }
}