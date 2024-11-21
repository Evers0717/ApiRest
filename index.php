<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


require_once('config/database.php');
require_once('controllers/CostumerController.php');
require_once('controllers/AddressController.php');
require_once('controllers/CategoriesController.php');
require_once('controllers/ProviderController.php');
require_once('controllers/ProductsController.php');
require_once('controllers/CartController.php');
require_once('controllers/OrderController.php');



$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));


$controllerName = ucfirst(strtolower($requestUri[1])) . 'Controller';
$action = strtolower($requestUri[2]);
$param = isset($requestUri[3]) ? $requestUri[3] : null;

if (class_exists($controllerName) && method_exists($controllerName, $action)) {
    $controller = new $controllerName();


    if ($param !== null) {
        $controller->$action($param);
    } else {
        $controller->$action();
    }
} else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["message" => "Método no encontrado."]);
}
