<?php 

namespace App\Tests;

use App\Exceptions\NotFoundException;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Services\CategoryService;
use PHPUnit\Framework\TestCase;

class CategoryServiceTest extends TestCase
{

    //getAll method tests
    public function testGetAllReturnsCategoriesCorrectly()
    {
        $categories = [
            ['id' => 1, 'name' => 'Category 1'],
            ['id' => 2, 'name' => 'Category 2'],
            ['id' => 3, 'name' => 'Category 3'],
        ];

        $categoryRepositoryMock = $this->createMock(CategoryRepositoryInterface::class);
        $categoryRepositoryMock
            ->method('getAll')
            ->willReturn($categories);

        $categoryService = new CategoryService($categoryRepositoryMock);
        $result = $categoryService->getAll();

        $this->assertEquals($categories, $result);
    }

    public function testGetAllCategoriesWhenHaveNoCategoriesRegistered()
    {
        $categories = [];

        $categoryRepositoryMock = $this->createMock(CategoryRepositoryInterface::class);
        $categoryRepositoryMock
            ->method('getAll')
            ->willReturn($categories);

        $categoryService = new CategoryService($categoryRepositoryMock);
        $result = $categoryService->getAll();

        $this->assertEquals($categories, $result);
    }

    //getById method tests
    public function testGetCategoryByIdReturnsCategoryCorrectly()
    {
        $category = ['id' => 1, 'name' => 'Category 1'];

        $categoryRepositoryMock = $this->createMock(CategoryRepositoryInterface::class);
        $categoryRepositoryMock
            ->method('getById')
            ->willReturn($category);

        $categoryService = new CategoryService($categoryRepositoryMock);
        $result = $categoryService->getById(1);

        $this->assertEquals($category['id'], $result['id']);
    }

    public function testGetCategoryByIdMethodThrowsExceptionWhenNotCategoryFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches('/^Categoria não encontrada/');

        $categoryRepositoryMock = $this->createMock(CategoryRepositoryInterface::class);
        $categoryRepositoryMock
            ->method('getById')
            ->willReturn(null);
        
        $categoryService = new CategoryService($categoryRepositoryMock);
        $categoryService->getById(1);
    }

    //create method tests
    public function testCreateWithValidData()
    {
        $category = ['name' => 'Category 1'];
        $expectedResult = ['id' => 1] + $category;

        $categoryRepositoryMock = $this->createMock(CategoryRepositoryInterface::class);
        $categoryRepositoryMock
            ->method('create')
            ->with($category)
            ->willReturn($expectedResult);

        $categoryService = new CategoryService($categoryRepositoryMock);
        $result = $categoryService->create($category);

        $this->assertEquals($expectedResult, $result);
    }

    //update method tests
    public function testUpdateWithValidData()
    {
        $id = 1;
        $category = ['name' => 'Category 1'];
        $expectedOutput = ['id' => $id, 'name' => 'Category 1'];

        $categoryRepositoryMock = $this->createMock(CategoryRepositoryInterface::class);
        $categoryRepositoryMock->method('getById')->willReturn(true);
        $categoryRepositoryMock->method('update')->willReturn($expectedOutput);

        $categoryService = new CategoryService($categoryRepositoryMock);
        $categoryService->update($id,$category);

        $this->assertEquals($category['name'], $expectedOutput['name']);
        $this->assertEquals($id, $expectedOutput['id']);

    }

    public function testUpdateMethodThrowsExceptionWhenCategoryNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches('/^Categoria não encontrada/');
    
        $id = 1;
        $category = ['name' => 'Category 1'];
    
        $categoryRepositoryMock = $this->createMock(CategoryRepositoryInterface::class);
        $categoryRepositoryMock->method('getById')
            ->with($id)
            ->willReturn(false);
    
    
        $categoryService = new CategoryService($categoryRepositoryMock);
        $categoryService->update($id, $category);
    }

    //delete method tests
    public function testDeleteMethodThrowsExceptionWhenCategoryNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches('/^Categoria não encontrada/');

        $categoryRepositoryMock = $this->createMock(CategoryRepositoryInterface::class);
        $categoryRepositoryMock
            ->method('getById')
            ->willReturn(false);
    
        $categoryRepositoryMock
            ->method('delete')
            ->willReturn(null);

        $categoryService = new CategoryService($categoryRepositoryMock);
        $categoryService->delete(1);

    }
}