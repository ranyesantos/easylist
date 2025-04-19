<?php 

namespace App\Repositories\Size;

interface SizeRepositoryInterface
{
    public function getAll(): array;
    public function getById(int $id): ?array;
    public function create(array $data): array;
    public function update(int $id, array $data): array;
    public function delete(int $id): bool;
}