<?php 

namespace App\Repositories\Size;

use App\Db\Connection;
use App\Repositories\Size\SizeRepositoryInterface;
use PDO;

class SizeRepository implements SizeRepositoryInterface
{

    public function __construct(private PDO $pdo)
    {}

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM size");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM size WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $size = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $size ?: null;
    }

    public function create(array $data): array
    {
        $stmt = $this->pdo->prepare("INSERT INTO size (size_description) VALUES (:size_description)");
        $stmt->execute([
            'size_description' => $data['size_description']
        ]);

        return $this->getById((int)$this->pdo->lastInsertId());
    }

    public function update(int $id, array $data): array
    {
        $stmt = $this->pdo->prepare("UPDATE size SET size_description = :size_description WHERE id = :id");
        $stmt->execute([
            'size_description' => $data['size_description'],
            'id' => $id
        ]);

        return $this->getById($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM size WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return true;
    }

}