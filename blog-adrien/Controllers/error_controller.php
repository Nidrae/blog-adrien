<?php


class Error_Ctrl extends Ctrl{


    public function error_404()
    {
        $this->render('error_404_view');
    }

    public function error_405() {
        $this->render("error_405_view");

    }

}