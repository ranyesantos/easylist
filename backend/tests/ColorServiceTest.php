<?php 

namespace App\Tests;

use App\Exceptions\NotFoundException;
use App\Repositories\Color\ColorRepositoryInterface;
use App\Services\ColorService;
use PHPUnit\Framework\TestCase;

class ColorServiceTest extends TestCase
{

    //getAll method tests
    public function testGetAllColorsReturnsDataCorrectly()
    {
        $colors = [
            ['id' => 1, 'name' => "Red"],
            ['id' => 2, 'name' => "Green"],
            ['id' => 3, 'name' => "Blue"],
            ['id' => 4, 'name' => "Yellow"],
            ['id' => 5, 'name' => "Orange"],
        ];
        

        $colorRepositoryMock = $this->createMock(ColorRepositoryInterface::class);
        $colorRepositoryMock
            ->method('getAll')
            ->willReturn($colors);

        $colorService = new ColorService($colorRepositoryMock);
        $result = $colorService->getAll();

        $this->assertEquals($colors, $result);
    }

    public function testGetAllColorsWhenHaveNoColorsRegistered()
    {
        $colors = [];

        $colorRepositoryMock = $this->createMock(ColorRepositoryInterface::class);
        $colorRepositoryMock
            ->method('getAll')
            ->willReturn($colors);

        $colorService = new ColorService($colorRepositoryMock);
        $result = $colorService->getAll();

        $this->assertEquals($colors, $result);
    }

    //getById methods
    public function testGetColorByIdReturnsColorsCorrectly()
    {
        $id = 1;
        $color = ['id' => $id, 'name' => "Red"];

        $colorRepositoryMock = $this->createMock(ColorRepositoryInterface::class);
        $colorRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn($color);

        $colorService = new ColorService($colorRepositoryMock);
        $result = $colorService->getById($id);

        $this->assertEquals($color, $result);
    }

    public function testGetColorByIdMethodThrowsExceptionWhenColorNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches("/^Cor não encontrada/");

        $colorRepositoryMock = $this->createMock(ColorRepositoryInterface::class);
        $colorRepositoryMock
            ->method('getById')
            ->with(1)
            ->willReturn(null);

        $colorService = new ColorService($colorRepositoryMock);
        $colorService->getById(1);
    }

    //create method tests
    public function testCreateWithValidData()   
    {
        $color = ['name' => "Red"];
        $expectedResult = ['id'=> 1, 'name' => "Red"];

        $colorRepositoryMock = $this->createMock(ColorRepositoryInterface::class);
        $colorRepositoryMock
            ->method('create')
            ->with($color)
            ->willReturn($expectedResult);

        $colorService = new ColorService($colorRepositoryMock);
        $result = $colorService->create($color);

        $this->assertEquals($expectedResult, $result);
    }

    //update method tests
    public function testUpdateWithValidData()
    {
        $id = 1;
        $color = ['name' => "Red"];
        $expectedResult = ['id'=> $id, 'name' => "Red"];

        $colorRepositoryMock = $this->createMock(ColorRepositoryInterface::class);
        $colorRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn($expectedResult);
        $colorRepositoryMock
            ->method('update')
            ->with($id)
            ->willReturn($expectedResult);

        $colorService = new ColorService($colorRepositoryMock);
        $result = $colorService->update($id, $color);

        $this->assertEquals($expectedResult, $result);
    }

    public function testUpdateMethodThrowsExceptionWhenColorNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches('/^Cor não encontrada/');
        $id = 1;
        $color = ['name' => "Red"];

        $colorRepositoryMock = $this->createMock(ColorRepositoryInterface::class);
        $colorRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);
        
        $colorService = new ColorService($colorRepositoryMock);
        $colorService->update($id, $color);
    }

    //delete method test
    public function testDeleteMethodThrowsExceptionWhenColorNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches('/^Cor não encontrada/');

        $id = 1;
        $color = ['name' => "Red"];

        $colorRepositoryMock = $this->createMock(ColorRepositoryInterface::class);
        $colorRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);

        $colorService = new ColorService($colorRepositoryMock);
        $colorService->update($id, $color);
    }
}