<?php
    require_once "Login.php";
    require_once "Model.php";

    class CheckInController {
        public function checkInMenu($twig) {
            echo "inside checkin menu controller...";
            $connection = login();
            $model = new Model($connection);
            $prepareCarArray = $model->getAllCars();
            
            $carArray = [];
            
            foreach ($prepareCarArray as $value) {
                if ($value['checkOutTime'] != null) {
                    $carArray[] = $value;
                }
            }
            
            $map = ["carArray" => $carArray];
            return $twig->loadTemplate("CheckInView.twig")->render($map);  
        }

        public function checkInDone($twig) {
            echo "inside checkindone...";
            
            $connection = login();
            $model = new Model($connection);
            $model->addToHistory($connection); 
            $model->checkInCar($connection);
                
            return $twig->loadTemplate("CheckInDoneView.twig")->render([]);
        }
    }

?>