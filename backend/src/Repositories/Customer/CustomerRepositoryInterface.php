<?php 

namespace App\Repositories\Customer;

interface CustomerRepositoryInterface
{
    public function getAll(): array;
    public function getById(int $id): ?array;
    public function create(array $data): mixed;
    public function update(int $id, array $data): array;
    public function delete(int $id): bool;
}