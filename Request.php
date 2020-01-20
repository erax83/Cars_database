<?php

require_once "Login.php";
require_once "Model.php";

    // Requestklassen innehåller variablerna $path och $form.
    // $form innehåller iformation som skapas när anvädaren 
    // ändrar saker i formulären. 
    // $path innehåller pathdelen av webaddressen som behövs för
    // att routern ska kunna växla mellan olika paths.
    class Request {
        private $path;
        private $form;

        public function __construct() {
            $this->path = $_SERVER["REQUEST_URI"];
            $this->form = $_POST;
        }

        public function getPath() {
            return $this->path;
        }
        
        public function getForm() {
            return $this->form;
        }
        
    }
?>