<?php

namespace App\Repositories\ProductSize;

use App\Db\Connection;

class ProductSizeRepository implements ProductSizeRepositoryInterface
{
    private $pdo;

    public function __construct() 
    {
        $this->pdo = Connection::getPDO();
    }

    public function create($productColorId, $data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO product_size(price, stock, product_color_id, size_id) 
            VALUES(:price, :stock, :product_color_id, :size_id)"
        );

        $stmt->execute([
            'price' => $data['price'],
            'stock' => $data['stock'],
            'product_color_id' => $productColorId,
            'size_id' => $data['size_id']
        ]);    

        return $this->getById($this->pdo->lastInsertId()) ?: null;
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product_size WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $productSize = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;

        return $productSize;
        // var_dump('coorr',$color);
        // return $color;
    }


}