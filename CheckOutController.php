<?php
    require_once "Login.php";
    require_once "Model.php";

    class CheckOutController {
        public function checkOutMenu($twig) {
            echo "inside checkout menu controller...";
            $connection = login();
            $model = new Model($connection);
            $customerArray = $model->getAllCustomers();
            $prepareCarArray = $model->getAllCars();
            var_dump($prepareCarArray);
            $carArray = [];
            
            foreach ($prepareCarArray as $value) {
                if ($value['checkOutTime'] == null) {
                    $carArray[] = $value;
                }
            }
            
            $map = ["customerArray" => $customerArray, "carArray" => $carArray];
            return $twig->loadTemplate("CheckOutView.twig")->render($map);  
        }

        public function checkOutDone($twig) {
            echo "inside checkoutdone...";
            date_default_timezone_set("Europe/Stockholm");
            $checkOutTime = (date("Y-m-d h:i:sa"));
            $connection = login();
            $model = new Model($connection);
            $model->checkOutCar($connection, $checkOutTime);
            
            return $twig->loadTemplate("CheckOutDoneView.twig")->render([]);
        }
    }
?>
