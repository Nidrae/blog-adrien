<?php
// models/article_model.php - Gestion des articles

require_once("models/bdd.php");

class ArticleModel {
    private $pdo;

    public function __construct() {
        $bdd = new Bdd();
        $this->pdo = $bdd->getConnexion(); // Appel à la méthode correcte
    }

    public function getArticles() {
        $query = $this->pdo->prepare("SELECT A_ID, A_Titre, A_Image, LEFT(A_Contenu, 30) AS A_Contenu, A_DateCreation FROM T_Articles ORDER BY A_ID DESC LIMIT 9");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
