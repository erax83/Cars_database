<?php

require_once "Login.php";
require_once "Model.php";

    class Model {
        private $connection;

        public function __construct($connection) {
        $this->connection = $connection;
        }


        public function getAllCustomers() {
            $customerRows = $this->connection->query("select * from Customers");
            return $this->prepareCustomersRows($customerRows);
        }

        private function prepareCustomersRows($customerRows) {
            $customers = [];

            foreach ($customerRows as $customerRow) {
                $customerID = $customerRow["customerID"];
                $customerName = $customerRow["customerName"];
                $address = $customerRow["address"];
                $postalAddress = $customerRow["postalAddress"];
                $phoneNumber = $customerRow["phoneNumber"];

                $customer = ["customerID" => $customerID, "customerName" => $customerName, "address" => $address, "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber];
                $customers[] =  $customer;
            }
            return $customers;
        }

        public function getAllCars() {
            echo "inside getAll Cars Model...";
            $carRows = $this->connection->query("select regID, customerID, make, color, prodYear, price, checkOutTime from Cars");
            return $this->prepareCarsRows($carRows);
        }

        private function prepareCarsRows($carRows) {
            echo "inside prepare Cars...";
            $cars = [];

            foreach ($carRows as $carRow) {
                $regID = $carRow["regID"];
                $customerID = $carRow["customerID"];
                $make = $carRow["make"];
                $color = $carRow["color"];
                $prodYear = $carRow["prodYear"];
                $price = $carRow["price"];
                $checkOutTime = $carRow["checkOutTime"];

                $car = ["regID" => $regID, "customerID" => $customerID, "make" => $make, "color" => $color, "prodYear" => $prodYear, "price" => $price, "checkOutTime" => $checkOutTime];
                $cars[] = $car;
            }
            return $cars;
        }

        public function addCar($con) {
            $regID = ($_POST['regID']);
            $make = ($_POST['make']);
            $color = ($_POST['color']);
            $prodYear = ($_POST['prodYear']);
            $price = ($_POST['price']);


            $values = array(
                ':regID' => $regID,
                ':make' => $make,
                ':color' => $color,
                ':prodYear' => $prodYear,
                ':price' => $price
            );
            
            $query = 'INSERT INTO Cars (regID, make, color, prodYear, price) VALUES (:regID, :make, :color, :prodYear, :price)';

            try {
                $result = $con->prepare($query);
                $result->execute($values);
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
        }

        public function prepareEditCar($con, $regID) {
            $values = array(
                ':regID' => $regID
            );
            
            try {
                $result = $con->prepare("SELECT * from Cars where regID = :regID");
                $result->execute($values);

                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
            $carRow = $result->fetch();
                //var_dump($carRow);
            $regID = $carRow["regID"];
            $make = $carRow["make"];
            $color = $carRow["color"];
            $prodYear = $carRow["prodYear"];
            $price = $carRow["price"];

            $car = ["regID" => $regID, "make" => $make, "color" => $color, "prodYear" => $prodYear, "price" => $price];
            
            return $car;
        }

        public function editCar($con) {
            echo "inside editcar...";
            $regID = ($_POST['regID']);
            $make = ($_POST['make']);
            $color = ($_POST['color']);
            $prodYear = ($_POST['prodYear']);
            $price = ($_POST['price']);

            $values = array(
                ':regID' => $regID, 
                ':make' => $make,
                ':color' => $color,
                ':prodYear' => $prodYear,
                ':price' => $price 
            );
            
            $query = 'UPDATE Cars SET
                make = :make, color = :color, prodYear = :prodYear, price = :price
                WHERE regID = :regID';

            try {
                $result = $con->prepare($query);
                $result->execute($values);
                echo "test:" . $color;
                var_dump($values);
                echo "... editcar query executed...";
            }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
        }

        public function prepareDeleteCar($con, $regId) {
            echo $regId;
            $values = array(
                ':regId' => $regId
            );
            try {
                //echo $values[0];
                $resultDeleteCar = $con->prepare("DELETE from Cars where regID = :regId");
                $resultDeleteCar->execute($values);
                $resultDeleteHistory = $con->prepare("DELETE from RentalHistory where regID = :regId");
                $resultDeleteHistory->execute($values);
                echo "delete query executed...";
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                echo "delete query error...";
                die();
                }
        }

        public function addCustomer($con) {
            $customerID = ($_POST['customerID']);
            $customerName = ($_POST['customerName']);
            $address = ($_POST['address']);
            $postalAddress = ($_POST['postalAddress']);
            $phoneNumber = ($_POST['phoneNumber']);

            $values = array(
                ':customerID' => $customerID,
                ':customerName' => $customerName,
                ':address' => $address,
                ':postalAddress' => $postalAddress,
                ':phoneNumber' => $phoneNumber
            );
            
            $query = 'INSERT INTO Customers (customerID, customerName, address, postalAddress, phoneNumber) VALUES (:customerID, :customerName, :address, :postalAddress, :phoneNumber)';

            try {
                $result = $con->prepare($query);
                $result->execute($values);
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
        }

        public function prepareEditCustomer($con, $customerId) {
            $values = array(
                ':customerId' => $customerId
            );
           
            try {
                $result = $con->prepare("SELECT * from Customers where customerID = :customerId");
                $result->execute($values);

                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
            $customerRow = $result->fetch();
            var_dump($customerRow);
            $customerID = $customerRow["customerID"];
            $customerName = $customerRow["customerName"];
            $address = $customerRow["address"];
            $postalAddress = $customerRow["postalAddress"];
            $phoneNumber = $customerRow["phoneNumber"];

            $customer = ["customerID" => $customerID, "customerName" => $customerName, "address" => $address, "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber];
            
            return $customer;
        }

        public function editCustomer($con) {
            $customerID = ($_POST['customerID']);
            $customerName = ($_POST['customerName']);
            $address = ($_POST['address']);
            $postalAddress = ($_POST['postalAddress']);
            $phoneNumber = ($_POST['phoneNumber']);

            echo $customerName; 

            $values = array(
                ':customerID' => $customerID,
                ':customerName' => $customerName,
                ':address' => $address,
                ':postalAddress' => $postalAddress,
                ':phoneNumber' => $phoneNumber
            );

            $query = 'UPDATE Customers SET
                customerID = :customerID, customerName = :customerName, address = :address, postalAddress = :postalAddress, phoneNumber = :phoneNumber 
                WHERE customerID = :customerID';

            try {
                $result = $con->prepare($query);
                $result->execute($values);
            }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
        }

        public function prepareDeleteCustomer($con, $customerId) {
            echo $customerId;
            $values = array(
                ':customerId' => $customerId
            );
            try {
                $resultDeleteCustomer = $con->prepare("DELETE from Customers where customerID = :customerId");
                $resultDeleteCustomer->execute($values);
                $resultDeleteHistory = $con->prepare("DELETE from RentalHistory where customerID = :customerId");
                $resultDeleteHistory->execute($values);
                echo "delete queries executed...";
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                echo "delete query error...";
                die();
                }
        }

        public function getColors($con) {
            echo "inside getColor function...";
            try {
                $result = $con->prepare("SELECT color from CarColor");
                $result->execute();
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
            
            $colorArray = $result->fetchAll(PDO::FETCH_COLUMN);
            echo $colorArray[1];
            var_dump($colorArray);
            return $colorArray;
        }

        public function getBrands($con) {
            echo "inside getBrands function...";
            try {
                $result = $con->prepare("SELECT brand from CarBrand");
                $result->execute();
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
            
            $brandArray = $result->fetchAll(PDO::FETCH_COLUMN);
            echo $brandArray[1];
            var_dump($brandArray);
            return $brandArray;
        }

        public function checkOutCar($con, $time) {
            echo "inside checkOutCar function...";
            $customerID = ($_POST['customerID']);
            $regID = ($_POST['regID']);
            //$checkOutTime = $time;

            $values = array(
                ':customerID' => $customerID,
                ':regID' => $regID
                //':checkOutTime' => $checkOutTime
            );
            var_dump($values);
            $query = 'UPDATE Cars SET
                customerID = :customerID, checkOutTime = current_timestamp()  
                WHERE regID = :regID';

            try {
                $result = $con->prepare($query);
                $result->bindValue('customerID', $customerID, PDO::PARAM_STR);
                $result->bindValue('regID', $regID, PDO::PARAM_STR);
                //$result->bindValue('checkOutTime', $checkOutTime, PDO::PARAM_STR);
                $result->execute();
            }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
        }

        public function checkInCar($con) {
            echo "inside checkInCar model function...";

            $regID = ($_POST['regID']);
  
            $nullValue = NULL;
            $freeValue = 'Free';

            $values = array(
                ':regID' => $regID,
                ':nullValue' => $nullValue,
                ':freeValue' => $freeValue
            );

            $query = 'UPDATE Cars SET
                customerID = :freeValue,
                checkOutTime = :nullValue 
                WHERE regID = :regID';

            try {
            $result = $con->prepare($query);
            $result->execute($values);
            }
            catch (PDOException $e) {
            echo 'Query error: ' . $e->getMessage();
            die();
            }
        }

        public function addToHistory($con) {
            echo "inside addToHistory...";
            $regID = ($_POST['regID']);
            echo "regID: " . $regID;
            $infoValue = array(
                ':regID' => $regID
            );

            $infoQuery = 'SELECT customerID, checkOutTime, price from Cars where regID = :regID';

            try {
                $infoResult = $con->prepare($infoQuery);
                $infoResult->execute($infoValue);
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }

            $resultRow = $infoResult->fetch();

            $customerID = $resultRow["customerID"];
            $checkOutTime = $resultRow["checkOutTime"];
            $price = $resultRow["price"];

            date_default_timezone_set('Europe/Stockholm');
            $checkInTime = date('Y-m-d h:i:s');

            $checkOutTime = strtotime($checkOutTime);  
            $checkInTime = strtotime($checkInTime);  

            $diff = abs($checkInTime - $checkOutTime);  
  
            $years = floor($diff / (365*60*60*24));  
  
            $months = floor(($diff - $years * 365*60*60*24) 
                               / (30*60*60*24));  
  
            $days = floor(($diff - $years * 365*60*60*24 -  
            $months*30*60*60*24)/ (60*60*24));  
            
            echo "Date 1: " . $checkOutTime . "  Date 2: " . $checkInTime;
            echo "   Diff: " . $days;

            $cost = $days * $price;
            echo "Cost: " . $cost;

            $values = array(
                ':regID' => $regID,
                ':customerID' => $customerID,
                ':checkOutTime' => $checkOutTime,
                ':checkInTime' => $checkInTime,
                ':days' => $days,
                ':cost' => $cost
            );

            echo "Test: regID: " . $regID . " customerID: " . $customerID . " checkOutTime: " . $checkOutTime . " checkInTime: " . $checkInTime . " days: " . $days . " cost: " . $cost;

            $query = 'INSERT INTO RentalHistory (regID, customerID, checkOutTime, checkInTime, days, cost) VALUES
                (:regID, :customerID, :checkOutTime, :checkInTime, :days, :cost)';

            try {
                $result = $con->prepare($query);
                $result->execute($values);
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
        }

        public function getHistory() {
            echo "indide getHistory...";

            $historyRows = $this->connection->query("select * from RentalHistory");

            $historyArray = [];

            foreach ($historyRows as $historyRow) {
                $regID = $historyRow["regID"];
                $customerID = $historyRow["customerID"];
                $checkOutTime = $historyRow["checkOutTime"];
                $checkInTime = $historyRow["checkInTime"];
                $days = $historyRow["days"];
                $cost = $historyRow["cost"];

                $history = ["regID" => $regID, "customerID" => $customerID, "checkOutTime" => $checkOutTime, "checkInTime" => $checkInTime, "days" => $days, "cost" => $cost];
                $historyArray[] = $history;
            }
            return $historyArray;
            
        }
    }
?>

