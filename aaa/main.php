<?php
header("Content-Type: application/json; charset=UTF-8");
include "app/Route/ProductRoutes.php";

use app\Route\ProductRoutes;

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$productRoute = new ProductRoutes();
$productRoute->handle($method, $path);
