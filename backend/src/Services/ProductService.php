<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use \App\Repositories\Product\ProductRepositoryInterface;
use App\Utils\ServiceUtils;
use PDO;

class ProductService 
{

    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductColorService $productColorService,
        private ProductSizeService $productSizeService,    
        private ServiceUtils $serviceUtils,
        private PDO $pdo
    )
    {}

    public function getAll(): array 
    {
        $products = $this->productRepository->getAll();

        return $this->serviceUtils->formatProductData($products);
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
        
        $this->pdo->beginTransaction();

        try {
            $product = $this->productRepository->create($data);

            if (isset($data['product_colors']) && is_array($data['product_colors'])) {
                foreach ($data['product_colors'] as $colorData) {
                    $sizes = $colorData['size_data'] ?? [];
                    unset($colorData['size_data']);

                    $productColor = $this->productColorService->create($product['id'], $colorData);
                    
                    foreach ($sizes as $size) {
                        $this->productSizeService->create($productColor['id'], $size);
                    }
                }
            }

            $this->pdo->commit();

            return $this->getById($product['id']);
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
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
