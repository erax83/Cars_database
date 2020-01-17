<?php
    require_once "Login.php";
    require_once "Model.php";

    class CarsController {
        
        public function carsMenu($twig) {
            echo "inside carsMenu controller...";
            $connection = login();
            $model = new Model($connection);
            $carsArray = $model->getAllCars();

            $map = ["carsArray" => $carsArray];
            return $twig->loadTemplate("CarsView.twig")->render($map);
        }

        public function editCarPage($twig, $regID) {
            echo "inside edit car controller...";
            $connection = login();
            $model = new Model($connection);
            $getCar = $model->prepareEditCar($connection, $regID);
            
            $colors = $model->getColors($connection);
            $brands = $model->getBrands($connection);
            echo $colors[1];
            $map = ["getCar" => $getCar, "colors" => $colors, "brands" => $brands];
            var_dump($map);
            return $twig->loadTemplate("EditCarView.twig")->render($map);
        }

        public function carEdited($twig) {
            echo " inside carEdited controller...";
            $connection = login();
            $model = new Model($connection);
            $model->editCar($connection);
            
            return $twig->loadTemplate("CarEditedView.twig")->render([]);
        }

        public function deleteCar($twig, $regId) {
            echo "inside delete Customer Controller...";
            
            $connection = login();
            $model = new Model($connection);
            $getCar = $model->prepareDeleteCar($connection, $regId);
            
            return $twig->loadTemplate("DeleteCarView.twig")->render([]);
        }

        public function addCar($twig) {
            echo "inside addCar controller...";
            $connection = login();
            $model = new Model($connection);
            $colors = $model->getColors($connection);
            $brands = $model->getBrands($connection);
    
            $map = ["colors" => $colors, "brands" => $brands];
            return $twig->loadTemplate("AddCarView.twig")->render($map);
        }

        public function carAdded($twig) {
            $connection = login();
            $model = new Model($connection);
            $model->addCar($connection);
            
            return $twig->loadTemplate("CarAddedView.twig")->render([]);
        }
    }

?>