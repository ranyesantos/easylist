<?php 

namespace App\Services;

use App\Exceptions\NotFoundException;
use \App\Repositories\Customer\CustomerRepositoryInterface;

class CustomerService
{
    private $customerRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository
    ) 
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll(): array 
    {
        $customers = $this->customerRepository->getAll();

        return $customers;
    }

    public function getById(int $id): array
    {
        
        if (!$this->customerRepository->getById($id)) {
            throw new NotFoundException("Cliente não encontrado");
        }

        $customer = $this->customerRepository->getById($id);

        return $customer;
    }

    public function create(array $data): array
    {
        $customer = $this->customerRepository->create($data);

        return $customer;
    }

    public function update(int $id, array $data): array
    {
        if (!$this->customerRepository->getById($id)) {
            throw new NotFoundException("Cliente não encontrado");
        }

        return $this->customerRepository->update($id, $data);
    }

    public function delete(int $id): void 
    {
        if (!$this->customerRepository->getById($id)) {
            throw new NotFoundException("Cliente não encontrado");
        }
        
        $this->customerRepository->delete($id);
    }
}