<?php 

namespace App\Tests;


use App\Http\Requests\ProductRequest;
use PHPUnit\Framework\TestCase;

class ProductRequestTest extends TestCase
{

    public function testWithValidData()
    {
        $requestData = [
            "name" =>"product",
            "price" => 8,
            "stock" => 2
        ];
        $errors = ProductRequest::validate($requestData);
        
        $this->assertEquals(null, $errors);
    }

    public function testWithNullValueOnNameField()
    {
        $requestData = [
            "name" => "",
            "price" => 8,
            "stock" => 2
        ];
        $errors = ProductRequest::validate($requestData);

        $this->assertEquals(['name' => "O nome do produto não pode estar vazio."], $errors);
    }

    public function testWithNegativePrice()
    {
        $requestData = [
            "name" =>"product",
            "price" => -8,
            "stock" => 2
        ];
        $errors = ProductRequest::validate($requestData);

        $this->assertEquals(['price' => "O preço deve ser um número maior que zero."], $errors);
    }


    public function testWithNegativeStock()
    {
        $requestData = [
            "name" =>"a",
            "price" => 8,
            "stock" => -2
        ];

        $errors = ProductRequest::validate($requestData);

        $this->assertEquals(['stock' => "O estoque não pode ser negativo."], $errors);
    }

    public function testWithAllFieldsInvalid()
    {
        $requestData = [
            "name" => "",
            "price" => -8,
            "stock" => -2
        ];

        $errors = ProductRequest::validate($requestData);
        $expectedOutput = [
            'name' => "O nome do produto não pode estar vazio.",
            'price' => "O preço deve ser um número maior que zero.",
            'stock' => "O estoque não pode ser negativo."
        ];

        $this->assertEquals($expectedOutput, $errors);
    }
}
