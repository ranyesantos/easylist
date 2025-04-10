<?php 

namespace App\Services\Products;

use App\Exceptions\NotFoundException;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService 
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    
    public function getAll(): array
    {
        return $this->categoryRepository->getAll();
    }

    public function getById(int $id): array
    {
        $category = $this->categoryRepository->getById($id);

        if (!$category) {
            throw new NotFoundException("Categoria não encontrada");
        }

        return $category;
    }

    public function create(array $data): array
    {
        $category = $this->categoryRepository->create($data);

        return $category;
    }

    public function update(int $id, array $data): array
    {
        if (!$this->categoryRepository->getById($id)) {
            throw new NotFoundException("Categoria não encontrada");
        }

        return $this->categoryRepository->update($id, $data);
    }

    public function delete(int $id): void
    {
        if (!$this->categoryRepository->getById($id)) {
            throw new NotFoundException("Categoria não encontrada");
        }
        
        $this->categoryRepository->delete($id);
    }

}