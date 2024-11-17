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
        $query = $this->pdo->prepare("SELECT A_ID, A_Titre, A_Image, LEFT(A_Contenu, 30) AS A_Contenu, A_DateCreation FROM T_Articles ORDER BY A_ID DESC ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllArticlesPortfolio() {
        $query = $this->pdo->prepare("SELECT A_ID, A_Titre, A_Image, LEFT(A_Contenu, 100) AS A_Contenu, A_DateCreation FROM T_Articles ORDER BY A_ID DESC ");
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
            $query = "SELECT * FROM T_articles";
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


    public function getArticleById($id) {
        $query = "SELECT * FROM T_articles WHERE A_ID = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteArticleById($id) {
        $query = "UPDATE T_Articles 
                SET A_IsActif = 0 WHERE A_ID = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateArticle($data)
    {
        $sql = "UPDATE T_Articles 
                SET 
                    A_Titre = :A_Titre, 
                    A_Contenu = :A_Contenu, 
                    A_Image = :A_Image, 
                    A_Image2 = :A_Image2, 
                    A_Image3 = :A_Image3, 
                    A_Image4 = :A_Image4, 
                    A_Image5 = :A_Image5, 
                    A_Image6 = :A_Image6, 
                    A_Image7 = :A_Image7, 
                    A_Image8 = :A_Image8, 
                    A_Image9 = :A_Image9, 
                    A_Pays = :A_Pays 
                WHERE A_ID = :A_ID";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':A_Titre', $data['A_Titre'], PDO::PARAM_STR);
        $stmt->bindValue(':A_Contenu', $data['A_Contenu'], PDO::PARAM_STR);
        $stmt->bindValue(':A_Image', $data['A_Image'], PDO::PARAM_STR);
        $stmt->bindValue(':A_Image2', $data['A_Image2'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':A_Image3', $data['A_Image3'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':A_Image4', $data['A_Image4'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':A_Image5', $data['A_Image5'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':A_Image6', $data['A_Image6'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':A_Image7', $data['A_Image7'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':A_Image8', $data['A_Image8'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':A_Image9', $data['A_Image9'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':A_Pays', $data['A_Pays'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':A_ID', $data['A_ID'], PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    
    public function saveArticleToHistory($articleId)
    {
        // Récupérer l'article à partir de son ID
        $sqlSelect = "SELECT 
                        A_Titre, A_Image, A_Contenu, A_DateCreation, U_ID,
                        A_Image2, A_Image3, A_Image4, A_Image5, A_Image6,
                        A_Image7, A_Image8, A_Image9, A_Pays
                      FROM T_Articles
                      WHERE A_ID = :A_ID";
    
        $stmtSelect = $this->pdo->prepare($sqlSelect);
        $stmtSelect->bindValue(':A_ID', $articleId, PDO::PARAM_INT);
        $stmtSelect->execute();
    
        $article = $stmtSelect->fetch(PDO::FETCH_ASSOC);
    
        if (!$article) {
            throw new Exception("Article avec l'ID $articleId introuvable.");
        }
    
        // Insérer les données de l'article dans la table historique
        $sqlInsert = "INSERT INTO T_Histo_Articles 
                        (HA_Titre, HA_Image, HA_Contenu, HA_Datecreation, U_ID, 
                         HA_Image2, HA_Image3, HA_Image4, HA_Image5, HA_Image6, 
                         HA_Image7, HA_Image8, HA_Image9, HA_Pays, A_ID) 
                      VALUES 
                        (:HA_Titre, :HA_Image, :HA_Contenu, :HA_Datecreation, :U_ID, 
                         :HA_Image2, :HA_Image3, :HA_Image4, :HA_Image5, :HA_Image6, 
                         :HA_Image7, :HA_Image8, :HA_Image9, :HA_Pays, :A_ID)";
    
        $stmtInsert = $this->pdo->prepare($sqlInsert);
        $stmtInsert->bindValue(':HA_Titre', $article['A_Titre'], PDO::PARAM_STR);
        $stmtInsert->bindValue(':HA_Image', $article['A_Image'], PDO::PARAM_STR);
        $stmtInsert->bindValue(':HA_Contenu', $article['A_Contenu'], PDO::PARAM_STR);
        $stmtInsert->bindValue(':HA_Datecreation', $article['A_DateCreation'], PDO::PARAM_STR);
        $stmtInsert->bindValue(':U_ID', $article['U_ID'], PDO::PARAM_INT);
        $stmtInsert->bindValue(':HA_Image2', $article['A_Image2'] ?? null, PDO::PARAM_STR);
        $stmtInsert->bindValue(':HA_Image3', $article['A_Image3'] ?? null, PDO::PARAM_STR);
        $stmtInsert->bindValue(':HA_Image4', $article['A_Image4'] ?? null, PDO::PARAM_STR);
        $stmtInsert->bindValue(':HA_Image5', $article['A_Image5'] ?? null, PDO::PARAM_STR);
        $stmtInsert->bindValue(':HA_Image6', $article['A_Image6'] ?? null, PDO::PARAM_STR);
        $stmtInsert->bindValue(':HA_Image7', $article['A_Image7'] ?? null, PDO::PARAM_STR);
        $stmtInsert->bindValue(':HA_Image8', $article['A_Image8'] ?? null, PDO::PARAM_STR);
        $stmtInsert->bindValue(':HA_Image9', $article['A_Image9'] ?? null, PDO::PARAM_STR);
        $stmtInsert->bindValue(':HA_Pays', $article['A_Pays'] ?? null, PDO::PARAM_STR);
        $stmtInsert->bindValue(':A_ID', $articleId, PDO::PARAM_INT);
    
        return $stmtInsert->execute();
    }
    

    
    
    
}
