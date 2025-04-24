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

    public function getAll()
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.id AS product_id,
                p.name,
                ps.price
            FROM product p
            JOIN product_color pc ON pc.product_id = p.id
            JOIN product_size ps ON ps.product_color_id = pc.id
            WHERE pc.id = (
                SELECT MIN(pc2.id)
                FROM product_color pc2
                WHERE pc2.product_id = p.id
            )
            AND ps.id = (
                SELECT MIN(ps2.id)
                FROM product_size ps2
                WHERE ps2.product_color_id = pc.id
            )
        ");

        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $data;
    }

    public function getById(int $id): array
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.id AS product_id, 
                p.name, 
                p.description, 
                pc.id AS product_color_id, 
                pc.name AS color_name, 
                pc.picture_url, 
                pc.color_id, 
                ps.price,
                ps.stock,
                s.size_description AS size
            FROM product p
            LEFT JOIN product_color pc ON pc.product_id = p.id
            LEFT JOIN product_size ps ON ps.product_color_id = pc.id
            LEFT JOIN size s ON s.id = ps.size_id
            WHERE p.id = :id
        ");

        $stmt->execute(['id' => $id]);
        // var_dump($stmt->fetchAll(\PDO::FETCH_ASSOC));
        $productData = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        
        if (empty($productData)) {
            return [];
        }

        $product = [
            'product_id' => $productData[0]['product_id'],
            'name' => $productData[0]['name'],
            'description' => $productData[0]['description'],
            'product_colors' => []
        ];
        
        foreach ($productData as $row) {
            $product['product_colors'][] = [
                'picture_url' => $row['picture_url'],
                'product_color_id' => $row['product_color_id'],
                'color_id' => $row['color_id'],
                'name' => $row['color_name'],
                'price' => $row['price'],
                'stock' => $row['stock'],
                'size' => $row['size'],
            ];
        }

        return $product;
    }

    public function create(array $data): array
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("
                INSERT INTO product (name, description)
                VALUES (:name, :description)
            ");
            $stmt->execute([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

            $productId = (int)$this->pdo->lastInsertId();

            $stmtProductColor = $this->pdo->prepare("
                INSERT INTO product_color (name, picture_url, product_id, color_id)
                VALUES (:name, :picture_url, :product_id, :color_id)
            ");

            $stmtProductSize = $this->pdo->prepare("
                INSERT INTO product_size (price, product_color_id, size_id)
                VALUES (:price, :product_color_id, :size_id)
            ");

            $productColors = [];

            // insert product_color entries
            foreach ($data['product_colors'] as $productColor) {
                // insert the product color
                $stmtProductColor->execute([
                    'name' => $productColor['name'] ?? $data['name'],
                    'picture_url' => $productColor['picture_url'],
                    'product_id' => $productId,
                    'color_id' => $productColor['color_id']
                ]);

                $productColorId = (int)$this->pdo->lastInsertId();

                // insert product size entries
                foreach ($productColor['size_data'] as $sizeData) {
                    $stmtProductSize->execute([
                        'product_color_id' => $productColorId,
                        'price' => $sizeData['price'],
                        'size_id' => $sizeData['size_id']
                    ]);
                    $productSizeIds[] = (int)$this->pdo->lastInsertId();
                }

                // use JOIN to select the product color and sizes
                $stmtProductColorSizes = $this->pdo->prepare("
                    SELECT 
                        pc.id AS product_color_id, 
                        pc.name AS color_name, 
                        pc.picture_url, 
                        pc.color_id, 
                        ps.price, 
                        s.size_description 
                    FROM product_color pc
                    LEFT JOIN product_size ps ON ps.product_color_id = pc.id
                    LEFT JOIN size s ON s.id = ps.size_id
                    WHERE pc.product_id = :product_id AND pc.id = :product_color_id
                ");

                $stmtProductColorSizes->execute([
                    'product_id' => $productId,
                    'product_color_id' => $productColorId
                ]);

                $productSizes = [];
                while ($row = $stmtProductColorSizes->fetch(\PDO::FETCH_ASSOC)) {
                    $productSizes[] = [
                        'price' => $row['price'],
                        'size_description' => $row['size_description'],
                    ];
                }

                $productColors[] = [
                    'product_color_id' => $productColorId,
                    'name' => $productColor['name'] ?? $data['name'],
                    'picture_url' => $productColor['picture_url'],
                    'color_id' => $productColor['color_id'],
                    'product_size' => $productSizes
                ];
            }

            $this->pdo->commit();

            return [
                'product_id' => $productId,
                'name' => $data['name'],
                'description' => $data['description'],
                'product_colors' => $productColors
            ];

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
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
