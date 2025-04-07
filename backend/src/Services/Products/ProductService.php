<?php

namespace App\Services\Products;

use App\Exceptions\NotFoundException;
use \App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService 
{

    private $productRepository;

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
        
        if (!$product) {
            throw new NotFoundException("Produto não encontrado");
        }

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
        if (!$this->productRepository->getById($id)) {
            throw new NotFoundException("Produto não encontrado");
        }
        
        $this->productRepository->delete($id);
    }
    
}
