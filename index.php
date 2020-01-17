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

echo "something is working...";
$request->requestTest();
echo $router->route($request, $twig);

/*
// Skriver ut från databasen
$testQuery = $connection->query("select * from Customers");
print_r ($testQuery);
var_dump ($connection);

foreach ($testQuery as $t) {
  echo " Namn: " . $t['customerName'];
}
*/


/*
// Databastest från model
$model = new Model($connection);
$model->getCustomers();
*/

?>