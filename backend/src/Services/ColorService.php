<?php 

namespace App\Services;

use App\Exceptions\NotFoundException;
use \App\Repositories\Color\ColorRepositoryInterface;

class ColorService
{

    private $colorRepository;

    public function __construct(
        ColorRepositoryInterface $colorRepository
    )
    {
        $this->colorRepository = $colorRepository;
    }

    public function getAll(): array
    {
        $colors = $this->colorRepository->getAll();

        return $colors;
    }

    public function getById(int $id): array
    {
        if (!$this->colorRepository->getById($id)){
            throw new NotFoundException("Cor não encontrada");
        }

        $color = $this->colorRepository->getById($id);

        return $color;
    }

    public function create($data): array
    {
        $color = $this->colorRepository->create($data);

        return $color;
    }

    public function update(int $id, array $data): array
    {
        if (!$this->colorRepository->getById($id)){
            throw new NotFoundException("Cor não encontrada");
        }

        $color = $this->colorRepository->update($id, $data);

        return $color;
    }

    public function delete(int $id): void
    {
        if (!$this->colorRepository->getById($id)){
            throw new NotFoundException("Cor não encontrada");
        }

        $this->colorRepository->delete($id);
    }
}