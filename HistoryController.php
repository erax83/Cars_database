<?php

    require_once "Login.php";
    require_once "Model.php";

    // När en bil lämnas tillbaka / checkas in så läggs detta till
    // i historiktabellen där det står hur mycket kunden ska betala. 
    class HistoryController {
        public function historyMenu($twig) {
            $connection = login();
            $model = new Model($connection);
            $historyArray = $model->getHistory();
            $map = ["historyArray" => $historyArray];
            return $twig->loadTemplate("HistoryView.twig")->render($map);
        }
    }

?>