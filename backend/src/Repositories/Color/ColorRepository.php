<?php 

namespace App\Repositories\Color;

use App\Db\Connection;
use App\Repositories\Color\ColorRepositoryInterface;
use PDO;

class ColorRepository implements ColorRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {}

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM color");
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM color WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $color = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;

        return $color;
    }

    public function create(array $data): array
    {
        $stmt = $this->pdo->prepare("INSERT INTO color (name) VALUES (:name)");
        $stmt->execute([
            'name' => $data['name']
        ]);
        
        return $this->getById($this->pdo->lastInsertId());
    }

    public function update(int $id, array $data): array
    {
        $stmt = $this->pdo->prepare("UPDATE color SET name = :name WHERE id = :id");
        $stmt->execute([
            'name' => $data['name']
        ]);

        return $this->getById($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM color WHERE id = :id");
        $stmt->execute([
            "id"=> $id
        ]);

        return true;
    }

}