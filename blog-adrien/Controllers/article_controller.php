<?php
require_once("models/article_model.php");

class Article_Ctrl extends Ctrl {
    private $articleModel;

    public function __construct() {
        $this->articleModel = new ArticleModel();
    }

    public function createArticle() {
        // Vérification que l'utilisateur est connecté et est administrateur
        if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] !== 1) {
            header("Location: index.php?ctrl=error&action=error_405");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['titre'];
            $image = $_FILES['image']['name'];
            $contenu = $_POST['contenu'];
            $pays = $_POST['pays'];
            $imagesOptionnelles = [];
            $userId = $_SESSION['user']['id'];

            // Répertoire pour stocker les images
            $uploadDir = __DIR__ . "/../Assets/images/";

            // Vérifier si le répertoire existe, sinon le créer
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            try {
                // Déplacer l'image principale
                $imagePath = $uploadDir . basename($image);
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    throw new Exception("Erreur lors du téléchargement de l'image principale.");
                }

                // Déplacer les images optionnelles
                foreach ($_FILES['images_optionnelles']['tmp_name'] as $key => $tmpName) {
                    if (!empty($tmpName)) {
                        $fileName = $_FILES['images_optionnelles']['name'][$key];
                        $filePath = $uploadDir . basename($fileName);
                        if (!move_uploaded_file($tmpName, $filePath)) {
                            throw new Exception("Erreur lors du téléchargement de l'image optionnelle : " . $fileName);
                        }
                        $imagesOptionnelles[] = $fileName; // Ajouter uniquement le nom du fichier
                    }
                }

                // Création de l'article
                $this->articleModel->createArticle($titre, $image, $contenu, $pays, $userId, $imagesOptionnelles);
                header("Location: index.php?ctrl=accueil&action=index");
                exit();
            } catch (Exception $e) {
                $error = $e->getMessage();
                $this->_arrData['error'] = $error;
                $this->display("create_article_view");
            }
        } else {
            $this->display("create_article_view");
        }
    }

    public function portfolio() {
        // Vérifie si un pays est sélectionné dans le formulaire
        $selectedCountry = $_POST['country'] ?? null;
        
        // Récupérer les pays distincts (pour le filtre)
        $countries = $this->articleModel->getDistinctCountries();
        
        // Récupérer les articles, filtrés si un pays est sélectionné
        $articles = $this->articleModel->getArticlesByCountry($selectedCountry);
    
        // Passer les données à la vue
        $this->_arrData['countries'] = $countries;
        $this->_arrData['articles'] = $articles;
        $this->_arrData['selectedCountry'] = $selectedCountry;
        
        // Charger la vue "portfolio_view"
        $this->display("portfolio_view");
    }
    

}
