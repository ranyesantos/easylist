<?php

namespace App\Repositories\Product;
use App\Db\Connection;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface 
{
    
    private $pdo;

    public function __construct() 
    {
        $this->pdo = Connection::getPDO();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product");
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }
    

    public function getById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;

        return $product;
    }

    public function create(array $data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO product (name, description) VALUES (:name, :description)");
        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
        
        return $this->getById($this->pdo->lastInsertId()) ?: null;
    }

    public function update(int $id, array $data)
    {
        $stmt = $this->pdo->prepare("UPDATE product SET name = :name, description = :description WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        return $this->getById($id);
    }

    public function delete(int $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM product WHERE id = :id");
        $stmt->execute([
            'id' => $id
        ]);

        return true;
    }
}
