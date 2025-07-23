<?php 

use App\Exceptions\NotFoundException;
use App\Repositories\Size\SizeRepositoryInterface;
use App\Services\SizeService;
use PHPUnit\Framework\TestCase;

class SizeServiceTest extends TestCase
{

    //getAll method tests
    public function testGetAllSizesReturnsDataCorrectly()
    {
        $sizes = [
            [
                'id' => 1,
                'size_description' => "XS"
            ],
            [
                'id' => 2,
                'size_description' => "S"
            ],
            [
                'id' => 3,
                'size_description' => "M"
            ],
            [
                'id' => 4,
                'size_description' => "L"
            ]
            
        ];

        $sizeRepositoryMock = $this->createMock(SizeRepositoryInterface::class);
        $sizeRepositoryMock
            ->method('getAll')
            ->willReturn($sizes);

        $sizeService = new SizeService($sizeRepositoryMock);
        $result = $sizeService->getAll();
        
        $this->assertEquals($sizes, $result);
    }

    public function testGetAllSizesWhenHaveNoSizesRegistered()
    {
        $sizes = [];

        $sizeRepositoryMock = $this->createMock(SizeRepositoryInterface::class);
        $sizeRepositoryMock
            ->method('getAll')
            ->willReturn($sizes);

        $sizeService = new SizeService($sizeRepositoryMock);
        $result = $sizeService->getAll();

        $this->assertEquals($sizes, $result);
    }

    //getById method tests
    public function testGetSizeByIdReturnsDataCorrectly()
    {
        $id = 1;
        $size = ['id' => $id, 'size_description' => "XS"];

        $sizeRepositoryMock = $this->createMock(SizeRepositoryInterface::class);
        $sizeRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn($size);

        $sizeService = new SizeService($sizeRepositoryMock);
        $result = $sizeService->getById($id);

        $this->assertEquals($size, $result);
    }

    public function testGetSizeByIdThrowsExceptionWhenSizeNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches("/^Tamanho não encontrado$/");
        $id = 1;

        $sizeRepositoryMock = $this->createMock(SizeRepositoryInterface::class);
        $sizeRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);

        $sizeService = new SizeService($sizeRepositoryMock);
        $sizeService->getById($id);
    }

    //create method tests
    public function testCreateWithValidData()
    {
        $data = ['size_description' => "XS"];
        $expectedResult = ['id' => 1, 'size_description' => "XS"];

        $sizeRepositoryMock = $this->createMock(SizeRepositoryInterface::class);
        $sizeRepositoryMock
            ->method('create')
            ->with($data)
            ->willReturn($expectedResult);
        
        $sizeService = new SizeService($sizeRepositoryMock);
        $result = $sizeService->create($data);

        $this->assertEquals($expectedResult, $result);
    }

    //update method tests
    public function testUpdateWithValidData()
    {
        $id = 1;
        $newData = ['size_description' => "GG"];
        $expectedResult = ['id' => $id, 'size_description' => "GG"];

        $sizeRepositoryMock = $this->createMock(SizeRepositoryInterface::class);
        $sizeRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn($expectedResult);

        $sizeRepositoryMock
            ->method('update')
            ->with($id, $newData)
            ->willReturn($expectedResult);
        
        $sizeService = new SizeService($sizeRepositoryMock);
        $result = $sizeService->update($id, $newData);

        $this->assertEquals($expectedResult, $result);
    }

    public function testUpdateMethodThrowsExceptionWhenSizeNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches("/^Tamanho não encontrado$/");
        $id = 1;
        $newData = ['size_description' => "GG"];

        $sizeRepositoryMock = $this->createMock(SizeRepositoryInterface::class);
        $sizeRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);
            
        $sizeService = new SizeService($sizeRepositoryMock);
        $sizeService->update($id, $newData);
    }

    //delete method tests
    public function testDeleteMethodThrowsExceptionWhenSizeNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches("/^Tamanho não encontrado$/");
        $id = 1;
        
        $sizeRepositoryMock = $this->createMock(SizeRepositoryInterface::class);
        $sizeRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);

        $sizeService = new SizeService($sizeRepositoryMock);
        $sizeService->delete($id);
    }

}