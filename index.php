<?php 

require_once __DIR__ . "/vendor/autoload.php"; 
$loader = new Twig_Loader_Filesystem(__DIR__); 
$twig = new Twig_Environment($loader); 

require_once "Login.php";
require_once "Request.php";
require_once "Router.php";
require_once "Model.php";

$request = new Request();
$router = new Router(); 
$connection = login();

echo $router->route($request, $twig);

?>