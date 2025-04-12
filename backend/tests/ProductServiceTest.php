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
            ['id' => 1, 'name' => 'Laptop', 'price' => 1500, 'stock' => 10],
            ['id' => 2, 'name' => 'Laptop', 'price' => 1100, 'stock' => 23],
            ['id' => 3, 'name' => 'Headphones', 'price' => 200, 'stock' => 50],
        ];        

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('getAll')->willReturn($products);
        $productRepositoryMock->expects($this->once())->method('getAll');

        $productService = new ProductService($productRepositoryMock);
        $result = $productService->getAll();

        $this->assertEquals($products, $result);
    }

    public function testGetAllProductsWhenHaveNoProductsRegistered()
    {
        $products = [];

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('getAll')->willReturn($products);
        $productRepositoryMock->expects($this->once())->method('getAll');
        
        $productService = new ProductService($productRepositoryMock);
        $result = $productService->getAll(); 

        $this->assertEquals($products, $result);
    }

    //getById method tests
    public function testGetProductByIdReturnsProductCorrectly()
    {
        $product = ['id' => 1, 'name' => 'Laptop', 'price' => 1500, 'stock' => 10];

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('getById')->willReturn($product);
        $productRepositoryMock->expects($this->once())->method('getById');

        $productService = new ProductService($productRepositoryMock);
        $result = $productService->getById(1);

        $this->assertEquals($product, $result);
    }

    public function testGetProductByIdMethodThrowsExceptionWhenNotProductFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Produto não encontrado'); 

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('getById')->willReturn(null);

        $productService = new ProductService($productRepositoryMock);
        $productService->getById(1);
    }

    //create method tests
    public function testCreateWithValidData()
    {
        $data = ['name' => 'Laptop', 'price' => 1500, 'stock' => 10];

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('create')->willReturn($data);
        $productRepositoryMock->expects($this->once())->method('create');

        $productService = new ProductService($productRepositoryMock);
        $result = $productService->create($data);

        $this->assertEquals($data, $result);
    }
    
    //update method tests
    public function testUpdateWithValidData()
    {
        $id = 1;
        $data = ['name' => 'Laptop', 'price' => 1500, 'stock' => 10];
        $expectedResult = ['id' => 1, 'name' => 'Laptop', 'price' => 1500, 'stock' => 10];

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('getById')->willReturn(true);
        $productRepositoryMock->method('update')->willReturn($expectedResult);
        $productRepositoryMock->expects($this->once())->method('update');

        $productService = new ProductService($productRepositoryMock);
        $result = $productService->update($id, $data);

        $this->assertEquals($expectedResult, $result);
    }

    public function testUpdateMethodThrowsExceptionWhenProductNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage("Produto não encontrado"); 

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productService = new ProductService($productRepositoryMock);
        $productService->update(1, ['nome' => 'produto inexistente']);
    }

    //delete method tests
    public function testDeleteCallsRepositoryWithCorrectId()
    {
        $id = 1;

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->method('getById')->willReturn(true);
        $productRepositoryMock->expects($this->once())->method('delete')->with($id);

        $productService = new ProductService($productRepositoryMock);
        $productService->delete($id);
    }

    public function testDeleteMethodThrowsExceptionWhenProductNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Produto não encontrado'); 

        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productService = new ProductService($productRepositoryMock);
        $productService->update(1, ['nome' => 'produto inexistente']);
    }

}