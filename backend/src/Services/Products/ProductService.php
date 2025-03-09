<?php

namespace App\Services\Products;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductValidationInterface;

class ProductService 
{

    private $productRepository;
    private $productValidator;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductValidationInterface $productValidator
    ) 
    {
        $this->productRepository = $productRepository;
        $this->productValidator = $productValidator;
    }

    public function getAll(): array 
    {
        $products = $this->productRepository->getAll();

        return $products;
    }

    public function getById(int $id): mixed
    {
        $product = $this->productRepository->getById($id);
        
        return $product;
    }

    public function create(array $data)
    {
        $product = $this->productRepository->create($data);

        return $product;
    }
    
    public function update(int $id, array $data)
    {
        $this->productValidator->validate($data);
        $product = $this->productRepository->update($id, $data);

        return $product;
    }

    public function delete(int $id): void 
    {
        $this->productRepository->delete($id);
    }
    
}
