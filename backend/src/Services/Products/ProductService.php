<?php

namespace App\Services\Products;

use App\Exceptions\NotFoundException;
use App\Interfaces\ProductRepositoryInterface;

class ProductService 
{

    private $productRepository;
    private $productValidator;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) 
    {
        $this->productRepository = $productRepository;
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
        if (!$this->productRepository->getById($id)) {
            throw new NotFoundException("Produto não encontrado");
        }

        return $this->productRepository->update($id, $data);
    }

    public function delete(int $id): void 
    {
        $this->productRepository->delete($id);
    }
    
}
