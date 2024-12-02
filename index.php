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
require_once('controllers/AdminController.php');
require_once('controllers/OrderDetailsController.php');
function sendJsonResponse($statusCode, $data)
{
    http_response_code($statusCode);
    header("Content-Type: application/json");
    echo json_encode($data);
    exit;
}


$basePath = 'ApiRest';


$requestUri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$requestUri = array_values(array_filter($requestUri));

if (empty($requestUri) || $requestUri[0] !== $basePath) {
    sendJsonResponse(404, ["message" => "Ruta no válida. BasePath no coincide."]);
}


array_shift($requestUri);


$controllerName = isset($requestUri[0]) ? ucfirst(strtolower($requestUri[0])) . 'Controller' : null;
$action = isset($requestUri[1]) ? strtolower($requestUri[1]) : null;
$params = array_slice($requestUri, 2);


error_log("Parsed Controller: $controllerName, Action: $action, Params: " . json_encode($params));

if ($controllerName === null || $action === null) {
    sendJsonResponse(400, ["message" => "Controlador o acción no especificados."]);
}


if (!class_exists($controllerName)) {
    sendJsonResponse(404, ["message" => "El controlador '$controllerName' no existe."]);
}

if (!method_exists($controllerName, $action)) {
    sendJsonResponse(404, ["message" => "La acción '$action' no existe en '$controllerName'."]);
}


try {
    $controller = new $controllerName();
    call_user_func_array([$controller, $action], $params);
} catch (Exception $e) {

    error_log("Error: " . $e->getMessage());
    sendJsonResponse(500, ["message" => "Ocurrió un error interno en el servidor.", "error" => $e->getMessage()]);
}
