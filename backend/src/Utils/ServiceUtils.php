<?php

namespace App\Utils;

class ServiceUtils
{
    public function formatProductData(array $rawData): array
    {
        $products = [];

        foreach ($rawData as $data) {
            $productId = $data['id'];
            $colorId = $data['product_color_id'];

            if (!isset($products[$productId])) {
                $products[$productId] = [
                    'id' => $data['id'],
                    'name' => $data['product_name'],
                    'description' => $data['description'],
                    'product_colors' => []
                ];
            }

            if (!isset($products[$productId]['product_colors'][$colorId])) {
                $products[$productId]['product_colors'][$colorId] = [
                    'product_color_id' => $colorId,
                    'name' => $data['color_name'],
                    'color_id' => $data['color_id'],
                    'picture_url' => $data['picture_url'],
                    'size_data' => []
                ];
            }

            $products[$productId]['product_colors'][$colorId]['size_data'][] = [
                'size_id' => (int)$data['size_id'],
                'price' => (float)$data['price'],
                'stock' => $data['stock']
            ];
        }

        $finalData = array_map(function ($product) {
            $product['product_colors'] = array_values($product['product_colors']);
            return $product;
        }, array_values($products));

        return $finalData;
    }
}