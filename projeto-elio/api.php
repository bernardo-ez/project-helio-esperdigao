
<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'system/Database.php';
require_once 'system/Router.php';
require_once 'api/src/dao/MarcaDAO.php';
require_once 'api/src/dao/CarroDAO.php';
require_once 'api/src/dao/TipoCarroDAO.php';
require_once 'api/src/models/MarcaModel.php';
require_once 'api/src/models/CarroModel.php';
require_once 'api/src/models/TipoCarroModel.php';
require_once 'api/src/controllers/MarcaController.php';
require_once 'api/src/controllers/CarroController.php';
require_once 'api/src/controllers/TipoCarroController.php';
require_once 'api/src/controllers/UserController.php';
require_once 'system/middleware/AuthMiddleware.php';
require_once 'system/middleware/TipoCarroMiddleware.php';

$database = new Database();
$db = $database->getConnection();

$router = new Router();

$marcaController = new MarcaController($db);
$carroController = new CarroController($db);
$tipoCarroController = new TipoCarroController($db);
$userController = new UserController();

// Rotas para Usuários (Login e Registro)
$router->addRoute('POST', '/login', [$userController, 'login']);
$router->addRoute('POST', '/register', [$userController, 'register']);

// Rotas para Marcas
$router->addRoute('GET', '/marcas', [$marcaController, 'read']);
$router->addRoute('GET', '/marcas/([0-9]+)', [$marcaController, 'readOne']);
$router->addRoute('POST', '/marcas', [$marcaController, 'create'], 'AuthMiddleware');
$router->addRoute('PUT', '/marcas/([0-9]+)', [$marcaController, 'update'], 'AuthMiddleware');
$router->addRoute('DELETE', '/marcas/([0-9]+)', [$marcaController, 'delete'], 'AuthMiddleware');

// Rotas para Tipos de Carro
$router->addRoute('GET', '/tiposcarro', [$tipoCarroController, 'read']);
$router->addRoute('GET', '/tiposcarro/([0-9]+)', [$tipoCarroController, 'readOne']);
$router->addRoute('POST', '/tiposcarro', [$tipoCarroController, 'create'], ['AuthMiddleware', 'TipoCarroMiddleware']);
$router->addRoute('PUT', '/tiposcarro/([0-9]+)', [$tipoCarroController, 'update'], ['AuthMiddleware', 'TipoCarroMiddleware']);
$router->addRoute('DELETE', '/tiposcarro/([0-9]+)', [$tipoCarroController, 'delete'], 'AuthMiddleware');

// Rotas para Carros
$router->addRoute('GET', '/carros', [$carroController, 'read']);
$router->addRoute('GET', '/carros/([0-9]+)', [$carroController, 'readOne']);
$router->addRoute('POST', '/carros', [$carroController, 'create'], 'AuthMiddleware');
$router->addRoute('PUT', '/carros/([0-9]+)', [$carroController, 'update'], 'AuthMiddleware');
$router->addRoute('DELETE', '/carros/([0-9]+)', [$carroController, 'delete'], 'AuthMiddleware');

try {
    $router->dispatch();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Erro interno do servidor: " . $e->getMessage()]);
}
