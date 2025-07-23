<?php

namespace App\Repositories\ProductColor;

use App\Db\Connection;
use PDO;

class ProductColorRepository implements ProductColorRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {}

    public function create($productId, $data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO product_color(name, picture_url, color_id, product_id) 
            VALUES(:name, :picture_url, :color_id, :product_id)"
        );
        
        $stmt->execute([
            'name' => $data['name'],
            'picture_url' => $data['picture_url'],
            'color_id' => $data['color_id'],
            'product_id' => $productId
        ]);
        
        return $this->getById($this->pdo->lastInsertId()) ?: null;
    }

    public function getById( $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product_color WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $color = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        
        return $color;
    }


}