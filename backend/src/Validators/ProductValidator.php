<?php 

namespace App\Validators;

use App\Interfaces\ProductValidationInterface;

class ProductValidator implements ProductValidationInterface
{
    
    private array $rules;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function validate(array $data): void
    {
        foreach ($this->rules as $rule) {
            $rule->validate($data);
        }
    }
}
