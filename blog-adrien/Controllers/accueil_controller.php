<!-- Controllers/accueil_controller.php -->
<?php
require_once("models/article_model.php");

class Accueil_Ctrl extends Ctrl {
    public function index() {
        $this->dataArray['strPage']	    = "Acceuil";
        $model = new ArticleModel();
        $this->dataArray['articles'] = $model->getArticles();
        $this->render("accueil_view");
        
    }

    public function about() {
        $this->render("about_view");
    }
}
?>
