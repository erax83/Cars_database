<?php

require_once "Login.php";
require_once "Model.php";
 
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
        
        public function requestTest() {
            echo "request working...";
        }
    }

?>