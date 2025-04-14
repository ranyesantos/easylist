<?php 

namespace App\Repositories\Customer;

use App\Db\Connection;
use App\Repositories\Customer\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    private $pdo;

    public function __construct() 
    {
        $this->pdo = Connection::getPDO();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM customer");
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM customer WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $customer = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;

        return $customer;
    }

    public function create(array $data): array
    {
        $stmt = $this->pdo->prepare("INSERT INTO customer (name, phone_number) VALUES (:name, :phone_number)");
        $stmt->execute([
            'name' => $data['name'],
            'phone_number' => $data['phone_number']
        ]);
        
        return $this->getById($this->pdo->lastInsertId());
    }

    public function update(int $id, array $data): array
    {
        $stmt = $this->pdo->prepare("UPDATE customer SET name = :name, phone_number = :phone_number WHERE id = :id");
        $stmt->execute([
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'id' => $id
        ]);

        return $this->getById($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM customer WHERE id = :id");
        $stmt->execute([
            "id"=> $id
        ]);

        return true;
    }

}