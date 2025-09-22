<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\ProductsController;
use App\Core\Application;
use App\Core\Router;

session_set_cookie_params(['secure' => true, 'httponly' => true, 'samesite' => 'lax']);
session_start();
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../docker');
$dotenv->load();

$app = new Application();

$router = new Router();

// Rotas principais
$router->get('/login', [AuthController::class, 'loginView']);
$router->post('/login', [AuthController::class, 'checkCredentials']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard', [ProductsController::class, 'dashboardView']);

$router->post('/products', [ProductsController::class, 'addProduct']);
$router->get('/products', [ProductsController::class, 'searchProducts']);
$router->get('/products/{id}', [ProductsController::class, 'getProductData']);
$router->post('/products/{id}/delete', [ProductsController::class, 'deleteProduct']);
$router->post('/products/{id}/edit', [ProductsController::class, 'editProduct']);

// Rota padrão em caso de URL inválida
$router->setMainRoute('/login');

try {
    $response = $router->dispatch($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
} catch (Exception $e) {
    http_response_code(500);
    echo "Erro interno do servidor: " . $e->getMessage();
    exit;
}

echo $response ?? 'No response found for the route.';
