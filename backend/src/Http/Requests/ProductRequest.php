<?php 

namespace App\Http\Requests;

class ProductRequest
{
    public static function validate($data): mixed
    {
        $errors = [];
        if (empty(trim($data['name']))) {
            $errors['name'] = "O nome do produto não pode estar vazio.";
        }

        if (!isset($data['price']) || !is_numeric($data['price']) || $data['price'] <= 0) {    
            $errors['price'] = "O preço deve ser um número maior que zero.";
        }

        if (!isset($data['stock']) || !is_numeric($data['stock']) || $data['stock'] < 0) {
            $errors['stock'] = "O estoque não pode ser negativo.";
        }

        return $errors ?: null;
    }
}
