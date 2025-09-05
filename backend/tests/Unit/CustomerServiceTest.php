<?php 

namespace Tests\Unit;

use App\Exceptions\NotFoundException;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Services\CustomerService;
use PHPUnit\Framework\TestCase;

class CustomerServiceTest extends TestCase
{
    // getAll method tests
    public function testGetAllCustomersReturnsDataCorrectly()
    {
        $customers = [
            [
                'id' => 1,
                'phone_number' => '+15551230001',
                'name' => 'Alice Johnson',
            ],
            [
                'id' => 2,
                'phone_number' => '+15551230002',
                'name' => 'Bob Smith',
            ],
            [
                'id' => 3,
                'phone_number' => '+15551230003',
                'name' => 'Charlie Davis',
            ],
        ];
        
        $customerRepositoryMock = $this->createMock(CustomerRepositoryInterface::class);
        $customerRepositoryMock
            ->method('getAll')
            ->willReturn($customers);
        
        $customerService = new CustomerService($customerRepositoryMock);
        $result = $customerService->getAll();

        $this->assertEquals($customers, $result);
    }

    public function testGetAllCustomersWhenHaveNoCustomersRegistered()
    {
        $customerRepositoryMock = $this->createMock(CustomerRepositoryInterface::class);
        $customerRepositoryMock
            ->method('getAll')
            ->willReturn([]);
        
        $customerService = new CustomerService($customerRepositoryMock);
        $result = $customerService->getAll();

        $this->assertEquals([], $result);
    }

    //getById method tests
    public function testGetCustomerByIdReturnsCustomerCorrectly()
    {
        $id = 1;
        $expectedOutput = ['id' => $id, 'phone_number' => '+15551230001','name' => 'Alice Johnson'];

        $customerRepositoryMock = $this->createMock(CustomerRepositoryInterface::class);
        $customerRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn($expectedOutput);
        
        $customerService = new CustomerService($customerRepositoryMock);
        $result = $customerService->getById($id);

        $this->assertEquals($expectedOutput, $result);
    }

    public function testGetCustomerByIdMethodThrowsExceptionWhenNotCustomerFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches('/^Cliente não encontrado/');

        $customerRepositoryMock = $this->createMock(CustomerRepositoryInterface::class);
        $customerRepositoryMock
            ->method('getById')
            ->willReturn(null);

        $customerService = new CustomerService($customerRepositoryMock);
        $customerService->getById(1);
    }

    //create method tests
    public function testCreateWithValidData()
    {
        $customer = ['phone_number' => '+15551230001', 'name' => 'Alice Johnson'];
        $expectedResult = ['id' => 1] + $customer;

        $customerRepositoryMock = $this->createMock(CustomerRepositoryInterface::class);
        $customerRepositoryMock
            ->method('create')
            ->with($customer)
            ->willReturn($expectedResult);

        $customerService = new CustomerService($customerRepositoryMock);
        $result = $customerService->create($customer);
        
        $this->assertEquals($expectedResult, $result);
    }

    //update method tests
    public function testUpdateWithValidData()
    {
        $id = 1;
        $customer = ['phone_number' => '+15551230001', 'name' => 'Alice Johnson'];
        $expectedOutput = ['id' => $id] + $customer;

        $customerRepositoryMock = $this->createMock(CustomerRepositoryInterface::class);
        $customerRepositoryMock
            ->method('getById')
            ->willReturn($expectedOutput);

        $customerRepositoryMock
            ->method('update')
            ->willReturn($expectedOutput);

        $customerService = new CustomerService($customerRepositoryMock);
        $result = $customerService->update($id,$customer);

        $this->assertEquals($expectedOutput, $result);
    }

    public function testUpdateMethodThrowsExceptionWhenCustomerNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches('/^Cliente não encontrado/');
        $id = 1;
        $customer = ['phone_number' => '+15551230001', 'name' => 'Alice Johnson'];

        $customerRepositoryMock = $this->createMock(CustomerRepositoryInterface::class);
        $customerRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);

        $customerService = new CustomerService($customerRepositoryMock);
        $customerService->update($id, $customer);

    }
    
    // delete method tests
    public function testDeleteMethodThrowsExceptionWhenCustomerNotFound()
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageMatches('/^Cliente não encontrado/');

        $id = 1;

        $customerRepositoryMock = $this->createMock(CustomerRepositoryInterface::class);
        $customerRepositoryMock
            ->method('getById')
            ->with($id)
            ->willReturn(null);

        $customerService = new CustomerService($customerRepositoryMock);
        $customerService->delete($id);
    }
}