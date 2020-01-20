<?php
    require_once "Login.php";
    require_once "Model.php";

    // Kunder och bilar hämtas via Model. Alla kunder visas 
    // men bara bilarna som inte redan är uthyrda finns tillgängliga.
    // Bilarna filtreras via foreachloopen.
    class CheckOutController {
        public function checkOutMenu($twig) {
            $connection = login();
            $model = new Model($connection);
            $customerArray = $model->getAllCustomers();
            $prepareCarArray = $model->getAllCars();
            
            $carArray = [];
            foreach ($prepareCarArray as $value) {
                if ($value['checkOutTime'] == null) {
                    $carArray[] = $value;
                }
            }
            
            $map = ["customerArray" => $customerArray, "carArray" => $carArray];
            return $twig->loadTemplate("CheckOutView.twig")->render($map);  
        }

        // Användarens val registreras i databasen via Model. 
        // CheckOutDoneView visar en bekräftelse.
        public function checkOutDone($twig) {
            $connection = login();
            $model = new Model($connection);
            $model->checkOutCar($connection);
            
            return $twig->loadTemplate("CheckOutDoneView.twig")->render([]);
        }
    }
?>
