<?php

class BaseController {
    protected array $dataArray = [];

    protected function render(string $templateName) {
    
        foreach ($this->dataArray as $key => $value) {
            $$key = $value;
        }

        include("views/_partial/header.php");
        include("Views/" . $templateName . ".php");
        include("views/_partial/footer.php");
    }
}
