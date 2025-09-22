<?php

namespace App\Services;

use App\models\ProductModel;

class ProductService
{
    public function addProduct(array $data): bool
    {
        $product = ProductModel::where('SKU', $data['sku']);
        
        if (!empty($product)) {
            return false;
        }
        
        ProductModel::insert($data);
        return true;
    }

    public function getAllProducts(): array
    {
        return ProductModel::select();
    }

    public function getProductById(int $id): ?array
    {
        return ProductModel::where('id', $id);
    }

    public function deleteProductById(int $id): void
    {
        ProductModel::delete($id);
    }

    public function updateProductById(int $id, array $data): void
    {
        ProductModel::update($id, $data);
    }

    public function searchProducts(string $query): array
    {
        $likeQuery = '%' . $query . '%';
        return ProductModel::query(
            "SELECT id, SKU, name, quantity, price FROM products WHERE name LIKE ? OR sku LIKE ? OR category LIKE ? OR supplier LIKE ?",
            [$likeQuery, $likeQuery, $likeQuery, $likeQuery]
        );
    }
}