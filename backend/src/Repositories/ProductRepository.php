<?php

namespace App\Repositories;
use App\Db\Connection;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface 
{
    
    private $pdo;

    public function __construct() 
    {
        $this->pdo = Connection::getPDO();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }
    

    public function getById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;

        return $product;
    }

    public function create(array $data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)");
        $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock']
        ]);
        
        return $this->getById($this->pdo->lastInsertId()) ?: null;
    }

    public function update(int $id, array $data)
    {
        $stmt = $this->pdo->prepare("UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id");
        $stmt->execute([
            "id" => $id,
            "name" => $data["name"],
            "price" => $data["price"],
            "stock" => $data["stock"]
        ]);

        return $this->getById($id);
    }

    public function delete(int $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute([
            "id"=> $id
        ]);

        return true;
    }
}
