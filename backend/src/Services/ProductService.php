<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use \App\Repositories\Product\ProductRepositoryInterface;
use App\Utils\ServiceUtils;

class ProductService 
{

    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductColorService $productColorService,
        private ProductSizeService $productSizeService,    
        private ServiceUtils $serviceUtils
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
        $product = $this->productRepository->create($data);
        
        if (isset($data['product_colors'])){
            $productColorData = $data['product_colors'];

            foreach ($productColorData as &$data) {
                $sizeData[] = $data['size_data'];
                unset($data['size_data']);
                
                $productColor[] = $this->productColorService->create($product['id'], $data);
            }
            for($i = 0; $i < count($productColor); $i++){
                $productId = $productColor[$i]['id'];

                for($p = 0; $p < count($sizeData[$i]); $p++){
                    $this->productSizeService->create($productId, $sizeData[$i][$p]);
                }

            }
        }

        return $this->getById($product['id']);
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
