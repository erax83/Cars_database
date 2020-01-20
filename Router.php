<?php

    require_once "Request.php";
    require_once "MainController.php";
    require_once "CustomersController.php";
    require_once "CarsController.php";
    require_once "CheckOutController.php";
    require_once "CheckInController.php";
    require_once "HistoryController.php";

        // I Router finns route-metoden som sköter växlandet mellan olika
        // sidor / paths. route-metoden slussar vidare användaren till 
        // nya sidor beroende på vilken path som angivs i twigfilerna.
        // Informationen kommer till route via metoderna i Requestklassen. 
    class Router {
        // route-metoden får information om path och formulärdata via 
        // argumenten $request och $twig.
        public function route($request, $twig) {
            $path = $request->getPath();
            $list = explode("/", $path);
            $form = $request->getForm();

            // $path är här detsamma som startsidan. 
            // Pathen avgör vilken ifsats som aktiveras.
            if($path == "/") {
                // Ett objekt av MainController-klassen skapas.
                // Metoden mainMenu kallas på och i den metoden 
                // hämtas twigfilen som visar startsidan. 
                $controller = new MainController();
                return $controller->mainMenu($twig);
            }

            else if($path == "/customersIndex") {
                $controller = new CustomersController();
                return $controller->customersMenu($twig);
            }

            else if($path == "/addCustomer") {
                $controller = new CustomersController();
                return $controller->addCustomerPage($twig);
            }

            else if($path == "/customerAdded") {
                $controller = new CustomersController();
                $idCheck = $controller->checkCustomerId($twig);
                if ($idCheck == true){
                    return $controller->customerAdded($twig);
                } 
            }

            else if($list[1] == "editCustomer") {
                $controller = new CustomersController();
                return $controller->editCustomerPage($twig, $list[2]);
            }

            else if($path == "/customerEdited") {
                $controller = new CustomersController();
                return $controller->customerEdited($twig);
            }

            else if($list[1] == "deleteCustomer") {
                $controller = new CustomersController();
                return $controller->deleteCustomer($twig, $list[2]);
            }

            else if($path == "/carsIndex") {
                $controller = new CarsController();
                return $controller->carsMenu($twig);
            }

            else if($path == "/addCar") {
                $controller = new CarsController();
                return $controller->addCar($twig);
            }

            else if($path == "/carAdded") {
                $controller = new CarsController();
                return $controller->carAdded($twig);
            }

            else if($list[1] == "editCar") {
                $controller = new CarsController();
                return $controller->editCarPage($twig, $list[2]);
            }

            else if($path == "/carEdited") {
                $controller = new CarsController();
                return $controller->carEdited($twig);
            }

            else if($list[1] == "deleteCar") {
                $controller = new CarsController();
                return $controller->deleteCar($twig, $list[2]);
            }

            else if($path == "/carCheckOut") {
                $controller = new CheckOutController();
                return $controller->checkOutMenu($twig);
            }

            else if($path == "/carCheckOutDone") {
                $controller = new CheckOutController();
                return $controller->checkOutDone($twig);
            }

            else if($path == "/carCheckIn") {
                $controller = new CheckInController();
                return $controller->checkInMenu($twig);
            }

            else if($path == "/carCheckInDone") {
                $controller = new CheckInController();
                return $controller->checkInDone($twig);
            }

            else if($path == "/history") {
                $controller = new HistoryController();
                return $controller->historyMenu($twig);
            }

            else {
                echo "Router error...";
            }
        }
    }

?>