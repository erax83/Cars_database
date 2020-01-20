<?php
    require_once "Login.php";
    require_once "Model.php";

    // När man vill checka in /lämna tillbaka en uthyrd bil.
    // Bilarna i databasen hämtas via Model.
    // I foreachloopen filtreras bilarna så att endast de som är 
    // uthyrda visas upp. Dessa är därefter valbara i CheckInView
    class CheckInController {
        public function checkInMenu($twig) {
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
        // Databasen uppdateras via Model när användaren valt bil.
        // CheckInDoneView visar en bekräftelse. 
        public function checkInDone($twig) {
            $connection = login();
            $model = new Model($connection);
            $model->addToHistory($connection); 
            $model->checkInCar($connection);
                
            return $twig->loadTemplate("CheckInDoneView.twig")->render([]);
        }
    }

?>