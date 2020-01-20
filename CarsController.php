<?php
    require_once "Login.php";
    require_once "Model.php";

            // Här samlas alla metoder som rör sidan med de listade bilarna.
    class CarsController {
            // Hämtar bilar från databasen och skickar dessa 
            // att visas med en twigfil.
        public function carsMenu($twig) {
            // Skapar kontakt med databasen via loginfunctionen i Login.php.
            $connection = login();
            // Skapar ett objekt av klassen Model och 
            // anropar getAllCars i Modelklassen där bilarna samlas i en array.
            $model = new Model($connection);
            $carsArray = $model->getAllCars();
            // Bilregistret samlas i $map och följer med till CarsView.twig.
            $map = ["carsArray" => $carsArray];
            return $twig->loadTemplate("CarsView.twig")->render($map);
        }

        // Tar fram bil som ska editeras samt valbara färger och bilmärken via Model. 
        // I EditCarView.twig kan användaren göra ändringar.
        public function editCarPage($twig, $regID) {
            $connection = login();
            $model = new Model($connection);
            $getCar = $model->prepareEditCar($connection, $regID);
            
            $colors = $model->getColors($connection);
            $brands = $model->getBrands($connection);

            $map = ["getCar" => $getCar, "colors" => $colors, "brands" => $brands];
            return $twig->loadTemplate("EditCarView.twig")->render($map);
        }
        // För vidare användarens ändringar till Model. 
        // CarEditedView visas som bekräftelse.
        public function carEdited($twig) {
            $connection = login();
            $model = new Model($connection);
            $model->editCar($connection);
            
            return $twig->loadTemplate("CarEditedView.twig")->render([]);
        }
        // Om användaren klickar på delete så skickas detta till Model.
        // DeleteCarView visas som bekräftelse.
        public function deleteCar($twig, $regId) {
            $connection = login();
            $model = new Model($connection);
            $getCar = $model->prepareDeleteCar($connection, $regId);
            
            return $twig->loadTemplate("DeleteCarView.twig")->render([]);
        }
        // Via Model hämtas register med valbara färger och bilmärken som sedan 
        // visas i AddCarView där man kan göra val för att lägga till en ny bil.
        public function addCar($twig) {
            $connection = login();
            $model = new Model($connection);

            $colors = $model->getColors($connection);
            $brands = $model->getBrands($connection);
    
            $map = ["colors" => $colors, "brands" => $brands];
            return $twig->loadTemplate("AddCarView.twig")->render($map);
        }
        // Val som gjorts för adderandet av en ny bil skickas till Model,
        // sedan visas CarAddedView som bekräftelse.
        public function carAdded($twig) {
            $connection = login();
            $model = new Model($connection);
            $model->addCar($connection);
            
            return $twig->loadTemplate("CarAddedView.twig")->render([]);
        }
    }
?>