<?php

namespace App\Repositories\Category;

use App\Db\Connection;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    private $pdo;
    
    public function __construct()
    {
        $this->pdo = Connection::getPDO();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM category");
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    public function getById(int $id): mixed
    {
        $stmt = $this->pdo->prepare("SELECT * FROM category WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $category = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;

        return $category;
    }

    public function create(array $data): mixed
    {
        $stmt = $this->pdo->prepare("INSERT INTO category (name) VALUES (:name)");
        $stmt->execute([
            'name' => $data['name']
        ]);
        
        return $this->getById($this->pdo->lastInsertId()) ?: null;
    }

    public function update(int $id, array $data): mixed
    {
        $stmt = $this->pdo->prepare("UPDATE category SET name = :name WHERE id = :id");
        $stmt->execute([
            "id" => $id,
            "name" => $data["name"]
        ]);

        return $this->getById($id);
    }
    
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM category WHERE id = :id");
        $stmt->execute([
            "id"=> $id
        ]);

        return $stmt->rowCount() > 0;
    }
}