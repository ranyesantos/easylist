<?php 

namespace App\Services;

use App\Exceptions\NotFoundException;
use \App\Repositories\Size\SizeRepositoryInterface;

class SizeService
{
    private SizeRepositoryInterface $sizeRepository;

    public function __construct(SizeRepositoryInterface $sizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
    }

    public function getAll(): array
    {
        return $this->sizeRepository->getAll();
    }

    public function getById(int $id): array
    {
        $size = $this->sizeRepository->getById($id);

        if (!$size) {
            throw new NotFoundException("Tamanho não encontrado");
        }

        return $size;
    }

    public function create(array $data): array
    {
        return $this->sizeRepository->create($data);
    }

    public function update(int $id, array $data): array
    {
        if (!$this->sizeRepository->getById($id)) {
            throw new NotFoundException("Tamanho não encontrado");
        }

        return $this->sizeRepository->update($id, $data);
    }

    public function delete(int $id): void
    {
        if (!$this->sizeRepository->getById($id)) {
            throw new NotFoundException("Tamanho não encontrado");
        }

        $this->sizeRepository->delete($id);
    }
}
