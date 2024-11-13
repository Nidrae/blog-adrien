<?php

 
    class Ctrl {
        // Déclarez la propriété
        protected array $_arrData = [];
    
        protected function display(string $strTemplate) {
            // Conversion des données du tableau en variables
            foreach ($this->_arrData as $key => $value) {
                $$key = $value;
            }
    
            include("views/_partial/header.php");
            include("Views/" . $strTemplate . ".php");
            include("views/_partial/footer.php");
        }
    }