<?php 

namespace App\Services;

use App\Repositories\ProductColor\ProductColorRepositoryInterface;

class ProductColorService
{

    private $productColorRepository;

    public function __construct(ProductColorRepositoryInterface $productColorRepositoryInterface) {
        $this->productColorRepository = $productColorRepositoryInterface;
    }
    
    public function create($productId, $data)
    {
        $productColor = $this->productColorRepository->create($productId, $data);
        
        return $productColor;
    }   
    
    public function getById( $id)
    {
        // $this->productColorRepository->getById($id);
    }
}