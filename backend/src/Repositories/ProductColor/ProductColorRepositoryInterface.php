<?php

namespace App\Repositories\ProductColor;

interface ProductColorRepositoryInterface 
{
    public function create($productColor, $data);
    public function getById($id);
}