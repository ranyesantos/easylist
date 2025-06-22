<?php

namespace App\Services;

use App\Repositories\ProductSize\ProductSizeRepositoryInterface;

class ProductSizeService 
{

    private $productSizeRepository;

    public function __construct(
        ProductSizeRepositoryInterface $productSizeRepository,
    )
    {
        $this->productSizeRepository = $productSizeRepository;
    }

    public function create($productColorId, $sizeData)
    {
        $sizeData = $this->productSizeRepository->create($productColorId, $sizeData);

        return $sizeData;
    }
}