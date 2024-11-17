<!-- Controllers/accueil_controller.php -->
<?php
require_once("models/article_model.php");

class Accueil_Ctrl extends Ctrl {
    public function index() {
        $model = new ArticleModel();
        $this->_arrData['articles'] = $model->getArticles();
        $this->display("accueil_view");
    }

    public function about() {
        $this->display("about_view");
    }
}
?>
