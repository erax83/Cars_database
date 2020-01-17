<?php
    require_once "Login.php";
    require_once "Model.php";

    class CustomersController {
        public function customersMenu($twig) {
            $connection = login();
            $model = new Model($connection);
            $customerArray = $model->getAllCustomers();

            $map = ["customerArray" => $customerArray];
            return $twig->loadTemplate("CustomersView.twig")->render($map);
        }

        public function addCustomerPage($twig) {
            return $twig->loadTemplate("AddCustomerView.twig")->render([]);
        }

        public function customerAdded($twig) {
            echo "inside customerAdded function controller...";
            $connection = login();
            $model = new Model($connection);
            $model->addCustomer($connection);
            
            return $twig->loadTemplate("CustomerAddedView.twig")->render([]);
        }

        public function editCustomerPage($twig, $customerId) {
            $connection = login();
            $model = new Model($connection);
            $getCustomer = $model->prepareEditCustomer($connection, $customerId);
            $map = ["getCustomer" => $getCustomer];
            var_dump($map);
            return $twig->loadTemplate("EditCustomerView.twig")->render($map);
        }

        public function customerEdited($twig) {
            $connection = login();
            $model = new Model($connection);
            $model->editCustomer($connection);
            
            return $twig->loadTemplate("CustomerEditedView.twig")->render([]);
        }

        public function deleteCustomer($twig, $customerId) {
            echo "inside delete Customer Controller...";
            $connection = login();
            $model = new Model($connection);
            $getCustomer = $model->prepareDeleteCustomer($connection, $customerId);
            return $twig->loadTemplate("CustomerDeletedView.twig")->render([]);
        }

        public function checkCustomerId($twig) {
            echo "inside check customer...";
            $id = ($_POST['customerID']);
            $idLength = strlen($id);
            $returnValue = false;
            if($idLength == 10) {
                $returnValue = true;
            }
            
            $contains_letters = preg_match('/^[0-9]+$/', $id);

            if($contains_letters == false) {
                echo "Answer: " . $contains_letters;
            }
            else {
                return $returnValue;
            }

            
        }
        
    }


?>