<?php 

namespace App\Tests;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductValidationInterface;
use App\Models\Product;
use App\Services\Products\ProductService;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{

    //getAll method tests
    public function testGetAllProductsReturnsProductsCorrectly()
    {
        $products = [
            ['id' => 1, 'name' => 'Laptop', 'price' => 1500, 'stock' => 10],
            ['id' => 2, 'name' => 'Laptop', 'price' => 1100, 'stock' => 23],
            ['id' => 3, 'name' => 'Headphones', 'price' => 200, 'stock' => 50],
        ];        

        $productValidationInterfaceMock = $this->createMock(ProductValidationInterface::class);
        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('getAll')->willReturn($products);
        $productRepositoryMock->expects($this->once())->method('getAll');

        $productService = new ProductService($productRepositoryMock, $productValidationInterfaceMock);
        $result = $productService->getAll();

        $this->assertEquals($products, $result);
    }

    public function testGetAllProductsWhenHaveNoProductsRegistered()
    {
        $products = [];

        $productValidationInterfaceMock = $this->createMock(ProductValidationInterface::class);
        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('getAll')->willReturn($products);
        $productRepositoryMock->expects($this->once())->method('getAll');
        
        $productService = new ProductService($productRepositoryMock, $productValidationInterfaceMock);
        $result = $productService->getAll(); 

        $this->assertEquals($products, $result);
    }

    //getById method tests
    public function testGetProductByIdReturnsProductCorrectly()
    {
        $product = ['id' => 1, 'name' => 'Laptop', 'price' => 1500, 'stock' => 10];

        $productValidationInterfaceMock = $this->createMock(ProductValidationInterface::class);
        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('getById')->willReturn($product);
        $productRepositoryMock->expects($this->once())->method('getById');

        $productService = new ProductService($productRepositoryMock, $productValidationInterfaceMock);
        $result = $productService->getById(1);

        $this->assertEquals($product, $result);
    }
 
    //create method tests
    public function testCreateWithValidData()
    {
        $data = ['name' => 'Laptop', 'price' => 1500, 'stock' => 10];

        $productValidationInterfaceMock = $this->createMock(ProductValidationInterface::class);
        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('create')->willReturn($data);
        $productRepositoryMock->expects($this->once())->method('create');

        $productService = new ProductService($productRepositoryMock, $productValidationInterfaceMock);
        $result = $productService->create($data);

        $this->assertEquals($data, $result);
    }
    
    //update method tests
    public function testUpdateWithValidData()
    {
        $id = 1;
        $data = ['name' => 'Laptop', 'price' => 1500, 'stock' => 10];
        $expectedResult = ['id' => 1, 'name' => 'Laptop', 'price' => 1500, 'stock' => 10];

        $productValidationInterfaceMock = $this->createMock(ProductValidationInterface::class);
        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('update')->willReturn($expectedResult);
        $productRepositoryMock->expects($this->once())->method('update');

        $productService = new ProductService($productRepositoryMock, $productValidationInterfaceMock);
        $result = $productService->update($id, $data);

        $this->assertEquals($expectedResult, $result);
    }

    //delete method tests
    public function testDeleteCallsRepositoryWithCorrectId()
    {
        $id = 1;

        $productValidationInterfaceMock = $this->createMock(ProductValidationInterface::class);
        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->expects($this->once())->method('delete')->with($id);

        $productService = new ProductService($productRepositoryMock, $productValidationInterfaceMock);
        $productService->delete($id);

    }

}