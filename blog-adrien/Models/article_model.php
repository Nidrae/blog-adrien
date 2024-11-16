<?php
// models/article_model.php - Gestion des articles

require_once("models/bdd.php");

class ArticleModel {
    private $pdo;

    public function __construct() {
        $bdd = new Bdd();
        $this->pdo = $bdd->getConnexion();
    }

    public function getArticles() {
        $query = $this->pdo->prepare("SELECT A_ID, A_Titre, A_Image, LEFT(A_Contenu, 30) AS A_Contenu, A_DateCreation FROM T_Articles ORDER BY A_ID ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllArticlesPortfolio() {
        $query = $this->pdo->prepare("SELECT A_ID, A_Titre, A_Image, LEFT(A_Contenu, 100) AS A_Contenu, A_DateCreation FROM T_Articles");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function createArticle($titre, $image, $contenu, $pays, $userId, $imagesOptionnelles = []) {
        // Validation du titre
        if (strlen($titre) > 255) {
            throw new Exception("Le titre est trop long (255 caractères maximum).");
        }

        // Préparer l'insertion
        $query = $this->pdo->prepare("
            INSERT INTO T_Articles (A_Titre, A_Image, A_Contenu, A_DateCreation, U_ID, A_Pays, A_Image2, A_Image3, A_Image4, A_Image5, A_Image6, A_Image7, A_Image8, A_Image9) 
            VALUES (:titre, :image, :contenu, NOW(), :userId, :pays, :image2, :image3, :image4, :image5, :image6, :image7, :image8, :image9)
        ");

        $images = array_pad($imagesOptionnelles, 8, null);

        // Exécuter l'insertion
        $query->execute([
            ':titre' => $titre,
            ':image' => $image,
            ':contenu' => $contenu,
            ':userId' => $userId,
            ':pays' => $pays,
            ':image2' => $images[0],
            ':image3' => $images[1],
            ':image4' => $images[2],
            ':image5' => $images[3],
            ':image6' => $images[4],
            ':image7' => $images[5],
            ':image8' => $images[6],
            ':image9' => $images[7],
        ]);
    }


    public function getArticlesByCountry($country = null) {
        if ($country) {
            // Retourne les articles pour le pays sélectionné
            $query = "SELECT * FROM T_articles WHERE A_Pays = :country";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':country', $country);
        } else {
            // Retourne tous les articles si aucun pays n'est sélectionné
            $query = "SELECT * FROM articles";
            $stmt = $this->pdo->prepare($query);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Récupérer tous les pays distincts
    public function getDistinctCountries() {
        $query = $this->pdo->prepare("
            SELECT DISTINCT A_Pays 
            FROM T_Articles 
            ORDER BY A_Pays
        ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
