<?php

namespace App\Repositories\Product;
use App\Db\Connection;
use App\Repositories\Product\ProductRepositoryInterface;
use Exception;

class ProductRepository implements ProductRepositoryInterface 
{
    
    private $pdo;

    public function __construct() 
    {
        $this->pdo = Connection::getPDO();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.id AS id,
                p.name AS product_name,
                p.description,
                
                pc.id AS product_color_id,
                pc.name AS color_name,
                pc.color_id,
                pc.picture_url,

                ps.id AS product_size_id,
                ps.size_id,
                ps.price,
                ps.stock
            FROM product p
            JOIN product_color pc ON pc.product_id = p.id
            JOIN product_size ps ON ps.product_color_id = pc.id
            ORDER BY p.id, pc.id, ps.id
        ");

        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $products;
    }

    public function getById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE id = :id");

        $stmt->execute(['id' => $id]);
        $rows = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $rows;
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
        $this->pdo->beginTransaction();

        $stmt = $this->pdo->prepare("
            UPDATE product SET name = :name, description = :description WHERE id = :id"
        );
        $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        $stmtProductColor = $this->pdo->prepare("
            UPDATE product_color
            SET name = :name,
                picture_url = :picture_url,
                color_id = :color_id
            WHERE id = :product_color_id
            ;
        ");

        $stmtSelectProductColor = $this->pdo->prepare("
            SELECT * FROM product_color WHERE product_id = :product_id
        ");
        $stmtSelectProductColor->execute([
            'product_id' => $id
        ]);
        
        $stmtProductColorSizes = $this->pdo->prepare("
            UPDATE product_size
            SET price = :price,
                stock = :stock,
                size_id = :size_id
            WHERE product_color_id = :product_color_id
            AND size_id = :size_id;
        ");

        foreach ($data['product_colors'] as $productColor){
            $stmtProductColor->execute([
                'name' => $productColor['name'],
                'picture_url' => $productColor['picture_url'],
                'product_color_id' => $productColor['id'],
                'color_id' => $productColor['color_id']
            ]);
            
            if (isset($productColor['size_data']) && is_array($productColor['size_data'])){
                foreach ($productColor['size_data'] as $sizeData){
                    $stmtProductColorSizes->execute([
                        'price' => $sizeData['price'],
                        'stock' => $sizeData['stock'],
                        'product_color_id' => $productColor['id'],
                        'size_id' => $sizeData['size_id']
                    ]);
                }
            }
        }

        $this->pdo->commit();

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
