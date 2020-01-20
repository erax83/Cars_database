<?php
    require_once "Login.php";
    require_once "Model.php";

        // Här samlas metoderna som rör sidan med kundregistret. 
    class CustomersController {

        // Kunderna hämtas från databasen via Model.
        // Listan med kunder visas sedan upp med CustomersView.
        public function customersMenu($twig) {
            $connection = login();
            $model = new Model($connection);
            $customerArray = $model->getAllCustomers();
            $map = ["customerArray" => $customerArray];
            return $twig->loadTemplate("CustomersView.twig")->render($map);
        }

        // Här laddas twigfilen där man kan lägga till nya kunder.
        public function addCustomerPage($twig) {
            return $twig->loadTemplate("AddCustomerView.twig")->render([]);
        }

        // När man gjort sina val för att lägga in en ny kund så skickas 
        // värdena till databasen via Model.
        public function customerAdded($twig) {
            $connection = login();
            $model = new Model($connection);
            $model->addCustomer($connection);
            return $twig->loadTemplate("CustomerAddedView.twig")->render([]);
        }

        // Information om gällande kund som man vill editera hämtsa från Model
        // med hjälp av personnummer från vald kund. 
        public function editCustomerPage($twig, $customerId) {
            $connection = login();
            $model = new Model($connection);
            $getCustomer = $model->prepareEditCustomer($connection, $customerId);
            $map = ["getCustomer" => $getCustomer];
            return $twig->loadTemplate("EditCustomerView.twig")->render($map);
        }
        // Ändringar av en kund skickas till Model. Sedan visas en bekräftelse.
        public function customerEdited($twig) {
            $connection = login();
            $model = new Model($connection);
            $model->editCustomer($connection);
            return $twig->loadTemplate("CustomerEditedView.twig")->render([]);
        }

        // Vald kund raderas från databasen via Model. 
        public function deleteCustomer($twig, $customerId) {
            $connection = login();
            $model = new Model($connection);
            $getCustomer = $model->prepareDeleteCustomer($connection, $customerId);
            return $twig->loadTemplate("CustomerDeletedView.twig")->render([]);
        }

        // Metod som kontrollerar personnummer. Jag har även försökt med detta 
        // med javascript i twigfilen. Jag tycker inte att jag har hittat någon 
        // perfekt metod för detta så jag har låtit både koden här nedan och javascriptkoden 
        // vara kvar tills vidare. 
        public function checkCustomerId($twig) {
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