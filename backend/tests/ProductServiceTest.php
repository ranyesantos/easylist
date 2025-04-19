<?php 

namespace App\Tests;

use App\Exceptions\NotFoundException;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\ProductService;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{

    //getAll method tests
    public function testGetAllProductsReturnsProductsCorrectly()
    {
        $products = [
            ['name' => "T-Shirt", 'description' => "Cotton tee"],
            ['name' => "Jeans", 'description' => "Slim fit"],
            ['name' => "Sneakers", 'description' => "Running shoes"]
        ];

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock
            ->method('getAll')
            ->willReturn($products);

        $productService = new ProductService($productRepositoryMock);
        $result = $productService->getAll();

        $this->assertEquals($products, $result);
    }

    public function testGetAllProductsWhenHaveNoProductsRegistered()
    {
        $products = [];

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock
            ->method('getAll')
            ->willReturn($products);
        
        $productService = new ProductService($productRepositoryMock);
        $result = $productService->getAll(); 

        $this->assertEquals($products, $result);
    }

    //getById method tests
    public function testGetProductByIdReturnsProductCorrectly()
    {
        $id = 1;
        $product = ['id' => $id, 'name' => "Sneakers", 'description' => "Running shoes"];

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn($product);

        $productService = new ProductService($productRepositoryMock);
        $result = $productService->getById($id);

        $this->assertEquals($product, $result);
    }

    public function testGetProductByIdMethodThrowsExceptionWhenNotProductFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches("/^Produto não encontrado$/"); 
        $id = 1;

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);

        $productService = new ProductService($productRepositoryMock);
        $productService->getById($id);
    }

    //create method tests
    public function testCreateWithValidData()
    {
        $data = ['name' => "Sneakers", 'description' => "Running shoes"];
        $expectedOutput = ['id' => 1, 'name' => "Sneakers", 'description' => "Running shoes"];

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock
            ->method('create')
            ->with($data)
            ->willReturn($expectedOutput);

        $productService = new ProductService($productRepositoryMock);
        $result = $productService->create($data);

        $this->assertEquals($expectedOutput, $result);
    }
    
    //update method tests
    public function testUpdateWithValidData()
    {
        $id = 1;
        $data = ['name' => "Sneakers", 'description' => "Running shoes"];
        $expectedOutput = ['id' => $id, 'name' => "Sneakers", 'description' => "Running shoes"];

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn($expectedOutput);

        $productRepositoryMock
            ->method('update')
            ->with($id, $data)
            ->willReturn($expectedOutput);

        $productService = new ProductService($productRepositoryMock);
        $result = $productService->update($id, $data);

        $this->assertEquals($expectedOutput, $result);
    }

    public function testUpdateMethodThrowsExceptionWhenProductNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches("/^Produto não encontrado$/");
        $id = 1;
        $data = ['name' => "Sneakers", 'description' => "Running shoes"];

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);

        $productService = new ProductService($productRepositoryMock);
        $productService->update($id, $data);
    }

    //delete method tests

    public function testDeleteMethodThrowsExceptionWhenProductNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches("/^Produto não encontrado$/");
        $id = 1;

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);


        $productService = new ProductService($productRepositoryMock);
        $productService->delete($id);
    }

}