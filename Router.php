<?php

    require_once "Request.php";
    require_once "MainController.php";
    require_once "CustomersController.php";
    require_once "CarsController.php";
    require_once "CheckOutController.php";
    require_once "CheckInController.php";
    require_once "HistoryController.php";
   
    class Router {
        public function route($request, $twig) {
            $path = $request->getPath();
            $list = explode("/", $path);
            print_r($list);
            $form = $request->getForm();
            echo "something in route is working...";

            if($path == "/") {
                echo "router main works...";
                $controller = new MainController();
                return $controller->mainMenu($twig);
            }

            else if($path == "/customersIndex") {
                echo "router customer works...";
                $controller = new CustomersController();
                return $controller->customersMenu($twig);
            }

            else if($path == "/addCustomer") {
                echo "router Add Customer works...";
                $controller = new CustomersController();
                return $controller->addCustomerPage($twig);
            }

            else if($path == "/customerAdded") {
                echo "router customer added works...";
                $controller = new CustomersController();
                $idCheck = $controller->checkCustomerId($twig);
                var_dump($idCheck);
                if ($idCheck == true){
                    return $controller->customerAdded($twig);
                } 
            }

            else if($list[1] == "editCustomer") {
                echo "router edit customer works...";
                $controller = new CustomersController();
                return $controller->editCustomerPage($twig, $list[2]);
            }

            else if($path == "/customerEdited") {
                echo "router customer edited works...";
                $controller = new CustomersController();
                return $controller->customerEdited($twig);
            }

            else if($list[1] == "deleteCustomer") {
                echo "router delete customer works...";
                $controller = new CustomersController();
                return $controller->deleteCustomer($twig, $list[2]);
            }

            else if($path == "/carsIndex") {
                echo "router carsIndex works...";
                $controller = new CarsController();
                return $controller->carsMenu($twig);
            }

            else if($path == "/addCar") {
                echo "router add car works...";
                $controller = new CarsController();
                return $controller->addCar($twig);
            }

            else if($path == "/carAdded") {
                echo "router car added works...";
                $controller = new CarsController();
                return $controller->carAdded($twig);
            }

            else if($list[1] == "editCar") {
                echo "router edit car works...";
                $controller = new CarsController();
                return $controller->editCarPage($twig, $list[2]);
            }

            else if($path == "/carEdited") {
                echo "router car edited works...";
                $controller = new CarsController();
                return $controller->carEdited($twig);
            }

            else if($list[1] == "deleteCar") {
                echo "router delete car works...";
                $controller = new CarsController();
                return $controller->deleteCar($twig, $list[2]);
            }

            else if($path == "/carCheckOut") {
                echo "router carsCheckOut works...";
                $controller = new CheckOutController();
                return $controller->checkOutMenu($twig);
            }

            else if($path == "/carCheckOutDone") {
                echo "router carsCheckOutDone works...";
                $controller = new CheckOutController();
                return $controller->checkOutDone($twig);
            }

            else if($path == "/carCheckIn") {
                echo "router carsCheckIn works...";
                $controller = new CheckInController();
                return $controller->checkInMenu($twig);
            }

            else if($path == "/carCheckInDone") {
                echo "router carsCheckInDone works...";
                $controller = new CheckInController();
                return $controller->checkInDone($twig);
            }

            else if($path == "/history") {
                echo "router history works...";
                $controller = new HistoryController();
                return $controller->historyMenu($twig);
            }

            else {
                echo "Router error...";
            }
        }
    }


?>