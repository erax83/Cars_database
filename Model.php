<?php

require_once "Login.php";

    // I Model samlas alla metoder som sköter kontakten med databasen. Metoderna
    // hämtar, lägger till, ändrar och raderar värden i databasen via querys.
    class Model {
        
        private $connection;
        // Connectionvariabeln används för att skapa kontakt med databasen. 
        public function __construct($connection) {
        $this->connection = $connection;
        }

        // I denna metoden finns en qury som hämtar all information från
        // Customertabellen i databasen. Värdena skickas en runda
        // till prepareCustomersRow där de sorteras i en array.
        // Denna skickas sedan tillbaka till Controllerdelen.
        public function getAllCustomers() {
            $customerRows = $this->connection->query("select * from Customers");
            return $this->prepareCustomersRows($customerRows);
        }

        // Här läggs värdena från varje rad i tabellen in i en array 
        private function prepareCustomersRows($customerRows) {
            $customers = [];
            
            foreach ($customerRows as $customerRow) {
                $customerID = $customerRow["customerID"];
                $customerName = $customerRow["customerName"];
                $address = $customerRow["address"];
                $postalAddress = $customerRow["postalAddress"];
                $phoneNumber = $customerRow["phoneNumber"];

                $check = false;
                $checkResult = $this->checkCustomer($customerID);
            
                if($checkResult != '') {
                    $check = true;
                }
                
                $customer = ["customerID" => $customerID, "customerName" => $customerName, "address" => $address, "postalAddress" => $postalAddress, "phoneNumber" => $phoneNumber, "check" => $check];
                $customers[] =  $customer;
            }
            return $customers;
        }

        // Denna metod används för att kontrollera om edit och deleteknapparna för en 
        // kund ska vara möjliga att använda eller ej.  
        public function checkCustomer($input) {
            $query = 'SELECT customerID FROM Cars WHERE customerID=:customerID';
            $values = array(
                ':customerID' => $input
            );
            try {
                $result = $this->connection->prepare($query);
                $result->execute($values);
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
            
            $getResult = $result->fetch();
            $returnValue = $getResult["customerID"];
    
            return $returnValue;
        }

        // Hämtar bilar från databasen. Samma logik som metoderna ovan.
        public function getAllCars() {
            $carRows = $this->connection->query("select regID, customerID, make, color, prodYear, price, checkOutTime from Cars");
            return $this->prepareCarsRows($carRows);
        }

        private function prepareCarsRows($carRows) {
            $cars = [];

            foreach ($carRows as $carRow) {
                $regID = $carRow["regID"];
                $customerID = $carRow["customerID"];
                $make = $carRow["make"];
                $color = $carRow["color"];
                $prodYear = $carRow["prodYear"];
                $price = $carRow["price"];
                $checkOutTime = $carRow["checkOutTime"];

                $check = false;
                $checkResult = $this->checkCar($customerID);
            
                if($checkResult != 'Free') {
                    $check = true;
                }

                $car = ["regID" => $regID, "customerID" => $customerID, "make" => $make, "color" => $color, "prodYear" => $prodYear, "price" => $price, "checkOutTime" => $checkOutTime, "check" => $check];
                $cars[] = $car;
            }
            return $cars;
        }

        public function checkCar($input) {
            $query = 'SELECT customerID FROM Cars WHERE customerID=:customerID';
            $values = array(
                ':customerID' => $input
            );
            try {
                $result = $this->connection->prepare($query);
                $result->execute($values);
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
            
            $getResult = $result->fetch();
            $returnValue = $getResult["customerID"];

            return $returnValue;
        }

        // Lägger till en ny bil i biltabellen.
        // Hämtar information från användarens input med hjälp av POST.
        // Användarens val skickas sedan vidare till databasen
        public function addCar($con) {
            // _POST innehåller information från formulär.
            $regID = ($_POST['regID']);
            $make = ($_POST['make']);
            $color = ($_POST['color']);
            $prodYear = ($_POST['prodYear']);
            $price = ($_POST['price']);
            $customerID = 'Free';
            // Värdena samlas i en array.
            $values = array(
                ':regID' => $regID,
                ':make' => $make,
                ':color' => $color,
                ':prodYear' => $prodYear,
                ':price' => $price,
                ':customerID' => $customerID
            );
            // Query som används för att lägga till värden i databasen.
            $query = 'INSERT INTO Cars (regID, make, color, prodYear, price, customerID) VALUES (:regID, :make, :color, :prodYear, :price, :customerID)';

            // Kontakten med databasen sker i två steg med prepare och sedan execute. 
            try {
                $result = $con->prepare($query);
                $result->execute($values);
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
        }
        // Metod som uppdaterar biltabellen i databasen utifrån bilens registreringsnummer.
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
            $regID = $carRow["regID"];
            $make = $carRow["make"];
            $color = $carRow["color"];
            $prodYear = $carRow["prodYear"];
            $price = $carRow["price"];

            $car = ["regID" => $regID, "make" => $make, "color" => $color, "prodYear" => $prodYear, "price" => $price];
            
            return $car;
        }

        // Biltabellen editeras 
        public function editCar($con) {
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

        // Bil raderas från databasen utifrån valt idnummer.
        public function prepareDeleteCar($con, $regId) {
            echo $regId;
            $values = array(
                ':regId' => $regId
            );
            try {
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

        // Kund läggs till i databasen.
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

        // Värden från vald kund hämtas från databasen utifrån idnummer
        // för att sedan kunna ändras i ett formulär.
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

        // Användarens val för editering av en kund hämtas från formuläret 
        // för att sedan skickas till databasen.
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

        // Vald kund raderas från databasen.
        public function prepareDeleteCustomer($con, $customerId) {
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

        // Metoden hämtar samtliga färger från färgtabellen. Dessa hamnar sedan i en dropdownmeny
        // när man lägger till eller endrar en bil. 
        public function getColors($con) {
            try {
                $result = $con->prepare("SELECT color from CarColor");
                $result->execute();
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
            
            $colorArray = $result->fetchAll(PDO::FETCH_COLUMN);
            return $colorArray;
        }

        // Metoden hämtar samtliga märken från märkestabellen. Dessa hamnar sedan i en dropdownmeny
        // när man lägger till eller endrar en bil.
        public function getBrands($con) {
            try {
                $result = $con->prepare("SELECT brand from CarBrand");
                $result->execute();
                }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
            
            $brandArray = $result->fetchAll(PDO::FETCH_COLUMN);
            return $brandArray;
        }

        // Metoden checkar ut en bil utifrån personnummer och registreringsnummer.
        public function checkOutCar($con) {
            $customerID = ($_POST['customerID']);
            $regID = ($_POST['regID']);

            $values = array(
                ':customerID' => $customerID,
                ':regID' => $regID
            );
            
            $query = 'UPDATE Cars SET
                customerID = :customerID, checkOutTime = current_timestamp()  
                WHERE regID = :regID';

            try {
                $result = $con->prepare($query);
                $result->bindValue('customerID', $customerID, PDO::PARAM_STR);
                $result->bindValue('regID', $regID, PDO::PARAM_STR);
                $result->execute();
            }
            catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                die();
                }
        }

        // Metoden checkar in en bil utifrån valt registreringsnummer.
        public function checkInCar($con) {
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

        // Metoden lägger till en ny rad i Historiktabellen när en 
        // bil checkats in. Kostnaden för uthyrningen räknas också ut
        // utifrån priset per dag och hur många dagar som bilen varit uthyrd. 
        public function addToHistory($con) {
            $regID = ($_POST['regID']);
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
            $months*30*60*60*24)/ (60*60*24)) + 1;  
            
            $cost = $days * $price;

            $values = array(
                ':regID' => $regID,
                ':customerID' => $customerID,
                ':checkOutTime' => $checkOutTime,
                ':checkInTime' => $checkInTime,
                ':days' => $days,
                ':cost' => $cost
            );

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

        // Metoden hämtar raderna från historiktabellen för att visas upp på historiksidan. 
        public function getHistory() {
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

