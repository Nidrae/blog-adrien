<?php


class Error_Ctrl extends Ctrl{


    public function error_404()
    {
        $this->display('error_404_view');
    }

    public function error_405() {
        $this->display("error_405_view");

    }

}