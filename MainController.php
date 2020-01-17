<?php

echo <<< _END
    <!DOCTYPE html>
    <html>
      <head>
        <title>Hello MVC!</title>
        <style>
            body {background-color: powderblue;
                    font-family: helvetica;        
            }
            h1   {color: blue;}
            p    {color: red;}
        </style>
      <head>
      <body>
_END;

require_once "Login.php";
require_once "Model.php";

    class MainController {
        public function mainMenu($twig) {
            echo "inside main controller...";
            return $twig->loadTemplate("MainMenuView.twig")->render([]);
        }
    }

    echo <<< _END
      </body>
    </html>
_END;


?>