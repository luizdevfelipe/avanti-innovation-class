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
$router->get('/dashboard', [ProductsController::class, 'dashboardView']);

// Rota padrão em caso de URL inválida
$router->setMainRoute('/login');

$response = $router->dispatch($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);

echo $response ?? 'No response found for the route.';
