<?php

namespace App\Services;

use App\models\ProductModel;

class ProductService
{
    public function addProduct(array $data): bool
    {
        $product = ProductModel::select('SKU')->where('SKU', $data['sku'])->first();
        
        if (!empty($product)) {
            return false;
        }
        
        ProductModel::insert($data);
        return true;
    }

    public function getAllProducts(): array
    {
        return ProductModel::select('id', 'SKU', 'name', 'quantity', 'price')->get();
    }

    public function getProductById(int $id): ?array
    {
        return ProductModel::select()->where('id', $id)->first();
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