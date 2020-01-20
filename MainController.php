<?php
  // html head som innehåller css-styling. 

echo <<< _END
    <!DOCTYPE html>
    <html>
      <head>
        <title>Car Rental</title>
        <style>
            body {background-color: whitesmoke;
                  color: color: #2D200B;
                  font-family: helvetica; }
            h1 {color: #2D200B;}
            p {color: darkbrown;}
            td {background-color: LightSteelBlue;
                padding: 8px; }
            input { background-color: white;
                    color: black; }
        </style>
      <head>
      <body>
_END;

require_once "Login.php";
require_once "Model.php";

    // Den här klassen hämtar starsidan.
    class MainController {
        public function mainMenu($twig) {
            return $twig->loadTemplate("MainMenuView.twig")->render([]);
        }
    }
    
echo <<< _END
      
      </body>
    </html>
_END;

?>