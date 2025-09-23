<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Services\ProductService;

class ProductsController
{
    public function __construct(
        private readonly Request $request,
        private readonly ProductService $productService
    ) {}

    /**
     * Renderiza a view do dashboard com a lista de produtos.
     */
    public function dashboardView()
    {
        if (isset($_SESSION['user_id'])) {
            $products = $this->productService->getAllProducts();
            return View::render('dashboard', ['products' => $products]);
        }

        header('Location: /login');
        exit;
    }

    /**
     * Adiciona um novo produto ao inventário.
     */
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
            $_SESSION['errors'] = $errors;
            header('Location: /dashboard');
            exit;
        }

        $is_newProduct = $this->productService->addProduct($data);

        if (!$is_newProduct) {
            $_SESSION['errors'][] = 'SKU já existe!';
        }

        header('Location: /dashboard');
        exit;
    }

    /**
     * Remove um produto do inventário pelo ID.
     * @param int $product_id O ID do produto a ser removido.
     */
    function deleteProduct(int $product_id)
    {
        $this->productService->deleteProductById($product_id);

        header('Location: /dashboard');
        exit;
    }

    /**
     * Edita os detalhes de um produto existente.
     * @param int $product_id O ID do produto a ser editado.
     */
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
            $_SESSION['errors'] = $errors;
            header('Location: /dashboard');
            exit;
        }

        $this->productService->updateProductById($product_id, $data);

        return header('Location: /dashboard');
    }

    /**
     * Obtém os dados de um produto específico pelo ID.
     * @param int $product_id O ID do produto a ser recuperado.
     */
    function getProductData(int $product_id)
    {
        $product = $this->productService->getProductById($product_id);

        header('Content-Type: application/json');
        echo json_encode($product);
        exit;
    }

    /**
     * Pesquisa produtos com base em uma consulta fornecida.
     */
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
