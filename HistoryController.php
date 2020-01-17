<?php

    require_once "Login.php";
    require_once "Model.php";

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