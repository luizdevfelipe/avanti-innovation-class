<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Services\ProductService;

use function PHPSTORM_META\type;

class ProductsController
{
    public function __construct(
        private readonly Request $request,
        private readonly ProductService $productService
    ) {}

    public function dashboardView()
    {
        if (isset($_SESSION['user_id'])) {
            $products = $this->productService->getAllProducts();
            return View::render('dashboard', ['products' => $products]);
        }

        header('Location: /login');
        exit;
    }

    public function dashboardViewErrors(array $errors)
    {
        if (isset($_SESSION['user_id'])) {
            $products = $this->productService->getAllProducts();
            return View::render('dashboard', ['products' => $products, 'errors' => $errors]);
        }

        header('Location: /login');
        exit;
    }

    public function addProduct()
    {
        $data = $this->request->input();

        $errors = $this->request->validate($data, [
            'name' => ['required', 'string'],
            'sku' => ['required', 'string'],
            'category' => ['string:null'],
            'price' => ['float:null'],
            'quantity' => ['integer:null'],
            'supplier' => ['string:null'],
            'description' => ['string:null'],
        ]);

        if (!empty($errors)) {
            $this->dashboardViewErrors($errors);
        }

        $this->productService->addProduct($data);

        return header('Location: /dashboard');
    }

    function deleteProduct(int $product_id)
    {
        $this->productService->deleteProductById($product_id);

        return header('Location: /dashboard');
    }

    function editProduct(int $product_id)
    {
        $data = $this->request->input();

        $errors = $this->request->validate($data, [
            'name' => ['required', 'string'],
            'sku' => ['required', 'string'],
            'category' => ['string:null'],
            'price' => ['float:null'],
            'quantity' => ['integer:null'],
            'supplier' => ['string:null'],
            'description' => ['string:null'],
        ]);

        if (!empty($errors)) {
            $this->dashboardViewErrors($errors);
        }

        $this->productService->updateProductById($product_id, $data);

        return header('Location: /dashboard');
    }

    function getProductData(int $product_id)
    {
        $product = $this->productService->getProductById($product_id);

        header('Content-Type: application/json');
        echo json_encode($product);
        exit;
    }

    function searchProducts()
    {
        $query = $this->request->input('q');
        
        if (empty($query)) {
            $products = $this->productService->getAllProducts();
        } else {
            $products = $this->productService->searchProducts($query);
        }

        header('Content-Type: application/json');
        echo json_encode(array_values($products));
        exit;
    }
}
