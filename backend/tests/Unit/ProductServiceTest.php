<?php 

namespace Tests\Unit;

use App\Exceptions\NotFoundException;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\ProductColorService;
use App\Services\ProductService;
use App\Services\ProductSizeService;
use App\Utils\ServiceUtils;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{

    private $productRepositoryMock;
    private $productColorServiceMock;
    private $productSizeServiceMock;
    private $serviceUtilsMock;
    private $productService;
    private $pdoMock;

    protected function setUp(): void
    {
        $this->productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $this->productColorServiceMock = $this->createMock(ProductColorService::class);
        $this->productSizeServiceMock = $this->createMock(ProductSizeService::class);
        $this->serviceUtilsMock = $this->createMock(ServiceUtils::class);
        $this->pdoMock = $this->createMock(\PDO::class);

        $this->productService = new ProductService(
            $this->productRepositoryMock,
            $this->productColorServiceMock,
            $this->productSizeServiceMock,
            $this->serviceUtilsMock,
            $this->pdoMock
        );
    }

    //getAll method tests
    public function testGetAllProductsReturnsFullDataCorrectly()
    {   

        $productData = [
            [
                'id' => 1,
                'product_name' => "product test 1",
                'description' => "text",
                'product_color_id' => 2,
                'color_name' => "product test - green",
                'color_id' => 1,
                'picture_url' => "link img - product green",
                'product_size_id' => 457,
                'size_id' => 23,
                'price' => 50,
                'stock' => "yes",
            ],
            [
                'id' => 1,
                'product_name' => "product test 1",
                'description' => "text",
                'product_color_id' => 2,
                'color_name' => "product test - green",
                'color_id' => 1,
                'picture_url' => "link img - product green",
                'product_size_id' => 458,
                'size_id' => 24,
                'price' => 60,
                'stock' => "yes",
            ],
            [
                'id' => 1,
                'product_name' => "product test 1",
                'description' => "text",
                'product_color_id' => 3,
                'color_name' => "product - black",
                'color_id' => 2,
                'picture_url' => "link img - product black",
                'product_size_id' => 459,
                'size_id' => 27,
                'price' => 70,
                'stock' => "yes",
            ],
            [
                'id' => 1,
                'product_name' => "product test 1",
                'description' => "text",
                'product_color_id' => 3,
                'color_name' => "product - black",
                'color_id' => 2,
                'picture_url' => "link img - product black",
                'product_size_id' => 460,
                'size_id' => 7,
                'price' => 90,
                'stock' => "yes",
            ],
            [
                'id' => 2,
                'product_name' => "product test 2",
                'description' => "text",
                'product_color_id' => 4,
                'color_name' => "product - red",
                'color_id' => 3,
                'picture_url' => "link img - product red",
                'product_size_id' => 461,
                'size_id' => 10,
                'price' => 100,
                'stock' => "yes",
            ],
            [
                'id' => 2,
                'product_name' => "product test 2",
                'description' => "text",
                'product_color_id' => 5,
                'color_name' => "product - red",
                'color_id' => 3,
                'picture_url' => "link img - product red",
                'product_size_id' => 462,
                'size_id' => 11,
                'price' => 110,
                'stock' => "yes",
            ],
        ];

        $expectedOutput = [
            [
                'id' => 1,
                'name' => 'product test 1',
                'description' => 'text',
                'product_colors' => [
                    [
                        'product_color_id' => 2,
                        'name' => 'product - verde',
                        'color_id' => 1,
                        'picture_url' => 'link img - product green',
                        'size_data' => [
                            ['size_id' => 23, 'price' => 50, 'stock' => 'yes'],
                            ['size_id' => 24, 'price' => 60, 'stock' => 'yes'],
                        ],
                    ],
                    [
                        'product_color_id' => 3,
                        'name' => 'product - preto',
                        'color_id' => 2,
                        'picture_url' => 'link img - product black',
                        'size_data' => [
                            ['size_id' => 27, 'price' => 70, 'stock' => 'yes'],
                            ['size_id' => 7, 'price' => 90, 'stock' => 'yes'],
                        ],
                    ],
                ]
            ],
            [
                'id' => 2,
                'name' => 'product test 2',
                'description' => 'text',
                'product_colors' => [
                    [
                        'product_color_id' => 4,
                        'name' => 'product - red',
                        'color_id' => 3,
                        'picture_url' => 'link img - product red',
                        'size_data' => [
                            ['size_id' => 10, 'price' => 100, 'stock' => 'yes'],
                            ['size_id' => 11, 'price' => 110, 'stock' => 'yes'],
                        ],
                    ]
                ]
            ]
        ];


        $this->productRepositoryMock
            ->method('getAll')
            ->willReturn($productData);
        
        $this->serviceUtilsMock
            ->method('formatProductData')
            ->willReturn($expectedOutput);

        $result = $this->productService->getAll();

        $this->assertEquals($expectedOutput, $result);

    }
    
    //create method tests
    public function testCreateProductWithOneSingleProductColor()
    {
        $id = 1;
        $colorId = 2;
        $productColorId = 3;
        $productColorSizeId = 4;

        $mainProductData["name"] = "product test 1";
        $mainProductData["description"] = "text";
        
        $product = $this->getSampleProductInput($colorId);

        $mainProductData['id'] = $id;
        $mainProductDataExpectedOutput = $mainProductData;
        
        $productColorData['id'] = $productColorId;
        $productColorData['product_id'] = $id;
        $productColorData['color_id'] = $colorId;
        $productColorDataExpectedOutput = $productColorData;

        $productSizeData = $product['product_colors'][0]['size_data'];
        $productSizeData['id'] = $productColorSizeId;
        $productSizeData['product_color_id'] = $productColorId;
        $productColorSizeExpectedOutput = $productSizeData;

        $expectedOutput = $this->getExpectedCreatedProduct($id, $colorId,$productColorId, $productColorSizeId);

        $this->productRepositoryMock
            ->method('create')
            ->willReturn($mainProductDataExpectedOutput);

        $this->productColorServiceMock
            ->method('create')
            ->willReturn($productColorDataExpectedOutput);

        $this->productSizeServiceMock
            ->method('create')
            ->willReturn($productColorSizeExpectedOutput);
        
        $this->productRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn($expectedOutput);

        $result = $this->productService->create($product);
        
        $this->assertEquals($expectedOutput, $result);
    }

    public function testCreateProductWithMoreThanOneProductColor()
    {
        $id = 1;
        $colorId1 = 10;
        $colorId2 = 11;
        $productColorId1 = 20;
        $productColorId2 = 21;
        $productColorSizeId1 = 30;
        $productColorSizeId2 = 31;

        $mainProductData["name"] = "product test 1";
        $mainProductData["description"] = "text";

        $product = $this->getSampleProductInput($colorId1, $colorId2);

        $mainProductData['id'] = $id;
        $mainProductDataExpectedOutput = $mainProductData;

        $productColorData1['id'] = $productColorId1;
        $productColorData1['product_id'] = $id;
        $productColorData1['color_id'] = $colorId1;
        $productColorDataExpectedOutput1 = $productColorData1;

        $productColorData2['id'] = $productColorId2;
        $productColorData2['product_id'] = $id;
        $productColorData2['color_id'] = $colorId2;
        $productColorDataExpectedOutput2 = $productColorData2;

        $expectedSizes = [
            [
                ["id" => $productColorSizeId1, "product_color_id" => $productColorId1, "size_id" => 23, "price" => 100, "stock" => "yes"],
                ["id" => $productColorSizeId1 + 1, "product_color_id" => $productColorId1, "size_id" => 24, "price" => 110, "stock" => "yes"]
            ],
            [
                ["id" => $productColorSizeId2, "product_color_id" => $productColorId2, "size_id" => 23, "price" => 200, "stock" => "yes"],
                ["id" => $productColorSizeId2 + 1, "product_color_id" => $productColorId2, "size_id" => 24, "price" => 210, "stock" => "yes"]
            ]
        ];
        
        $expectedOutput = $this->getExpectedCreatedProduct($id, $colorId1,$productColorId2, $productColorSizeId2, $colorId2, $productColorId2, $productColorSizeId2);

        $this->productRepositoryMock
            ->method('create')
            ->willReturn($mainProductDataExpectedOutput);

        $this->productColorServiceMock
            ->method('create')
            ->willReturnOnConsecutiveCalls(
                $productColorDataExpectedOutput1,
                $productColorDataExpectedOutput2
            );
        
        $this->productSizeServiceMock
            ->method('create')
            ->willReturnOnConsecutiveCalls(
                ...$expectedSizes[0],
                ...$expectedSizes[1]
            );

        $this->productRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn($expectedOutput);
        
        $result = $this->productService->create($product);
        
        $this->assertEquals($expectedOutput, $result);
    }

    //getById tests
    public function testGetProductByIdMethodThrowsExceptionWhenNotProductFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches("/^Produto não encontrado$/"); 
        $id = 1;

        $this->productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $this->productRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);

        $this->productService->getById($id);
    }


    private function getSampleProductInput($colorId, $colorId2 = null): array
    {
        if (isset($colorId2)){
            return [
                "name" => "product test 1",
                "description" => "text",
                "product_colors" => [
                    [
                        "name" => "product - green",
                        "color_id" => $colorId,
                        "picture_url" => "link - product 1",
                        "size_data" => [
                            ["size_id" => 23, "price" => 50, "stock" => "yes"],
                            ["size_id" => 24, "price" => 60, "stock" => "yes"],
                        ]
                    ],
                    [
                        "name" => "product - black",
                        "color_id" => $colorId2,
                        "picture_url" => "link - product 1",
                        "size_data" => [
                            ["size_id" => 23, "price" => 50, "stock" => "yes"],
                            ["size_id" => 24, "price" => 60, "stock" => "yes"],
                        ]
                    ]
                ]
            ];
        };
    
        return [
            "name" => "product test 1",
            "description" => "text",
            "product_colors" => [
                [
                    "name" => "product - green",
                    "color_id" => $colorId,
                    "picture_url" => "link - product 1",
                    "size_data" => [
                        ["size_id" => 23, "price" => 50, "stock" => "yes"],
                        ["size_id" => 24, "price" => 60, "stock" => "yes"],
                    ]
                ]
            ]
        ];
    }

    // update method tests
    public function testUpdateMethodThrowsExceptionWhenProductNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches("/^Produto não encontrado$/");
        $id = 1;
        $data = ['name' => "product test 1", 'description' => "text"];

        $this->productRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);

        $this->productService->update($id, $data);
    }

    // delete method tests
    public function testDeleteMethodThrowsExceptionWhenProductNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches("/^Produto não encontrado$/");
        $id = 1;
        
        $this->productRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);


        $this->productService->delete($id);
    }
    
    // auxiliary functions
    private function getExpectedCreatedProduct($id, $colorId1, $productColorId1, $productColorSizeId1, $colorId2 = null, $productColorId2 = null,  $productColorSizeId2 = null): array
    {
        if (isset($colorId2)){
            [
                "id" => $id,
                "name" => "product test 1",
                "description" => "text",
                "product_colors" => [
                    [
                        "id" => $productColorId1,
                        "product_id" => $id,
                        "name" => "product - green",
                        "color_id" => $colorId1,
                        "picture_url" => "link - product 1",
                        "size_data" => [
                            [
                                "id" => $productColorSizeId1,
                                "product_color_id" => $productColorId1,
                                "size_id" => 23,
                                "price" => 100,
                                "stock" => "yes"
                            ],
                            [
                                "id" => $productColorSizeId1 + 1,
                                "product_color_id" => $productColorId1,
                                "size_id" => 24,
                                "price" => 110,
                                "stock" => "yes"
                            ]
                        ]
                    ],
                    [
                        "id" => $productColorId2,
                        "product_id" => $id,
                        "name" => "product - black",
                        "color_id" => $colorId2,
                        "picture_url" => "link - product 2",
                        "size_data" => [
                            [
                                "id" => $productColorSizeId2,
                                "product_color_id" => $productColorId2,
                                "size_id" => 23,
                                "price" => 200,
                                "stock" => "yes"
                            ],
                            [
                                "id" => $productColorSizeId2 + 1,
                                "product_color_id" => $productColorId2,
                                "size_id" => 24,
                                "price" => 210,
                                "stock" => "yes"
                            ]
                        ]
                    ]
                ]
            ];
        }

        return [
            "id" => $id,
            "name" => "product test 1",
            "description" => "text",
            "product_colors" => [
                [
                    "id" => $productColorId1,
                    "product_id" => $id,
                    "name" => "product - green",
                    "color_id" => $colorId1,
                    "picture_url" => "link - product 1",
                    "size_data" => [
                        [
                            "id" => $productColorSizeId1,
                            "product_color_id" => $productColorId1,
                            "size_id" => 23,
                            "price" => 50,
                            "stock" => "yes"
                        ],
                        [
                            "id" => $productColorSizeId1 + 1,
                            "product_color_id" => $productColorId1,
                            "size_id" => 24,
                            "price" => 60,
                            "stock" => "yes"
                        ]
                    ]
                ]
            ]
        ];
    }  

    
}