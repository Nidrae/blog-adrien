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
                $this->dataArray['error'] = $error;
                $this->render("create_article_view");
            }
        } else {
            $this->render("create_article_view");
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
        $this->dataArray['countries'] = $countries;
        $this->dataArray['articles'] = $articles;
        $this->dataArray['selectedCountry'] = $selectedCountry;
        
        // Charger la vue "portfolio_view"
        $this->render("portfolio_view");
    }

    public function viewArticle() {
        // Récupérer l'ID de l'article depuis les paramètres de la requête
        $articleId = isset($_GET['id']) ? intval($_GET['id']) : null;
    
        if ($articleId) {
            // Récupérer les données de l'article correspondant
            $article = $this->articleModel->getArticleById($articleId);
            if ($article) {
                // Passer les données de l'article à la vue
                $this->dataArray['article'] = $article;
                $this->render("article_view");
            } else {
                // Article non trouvé
                echo "Article introuvable.";
            }
        } else {
            // Redirection si aucun ID n'est fourni
            header("Location: index.php?ctrl=article&action=portfolio");
            exit;
        }
    }
    
    public function deleteArticle() {
        // Vérifier si l'utilisateur est connecté et administrateur
        if (empty($_SESSION['user']) || $_SESSION['user']['is_admin'] !== 1) {
            header("Location: index.php?ctrl=accueil&action=index");
            exit;
        }
    
        // Récupérer l'ID de l'article depuis l'URL
        $articleId = isset($_GET['id']) ? intval($_GET['id']) : null;
    
        if ($articleId) {
            // Supprimer l'article via le modèle
            $deleted = $this->articleModel->deleteArticleById($articleId);
            if ($deleted) {
                header("Location: index.php?ctrl=article&action=portfolio&msg=deleted");
            } else {
                echo "Erreur lors de la suppression de l'article.";
            }
        } else {
            header("Location: index.php?ctrl=article&action=portfolio");
        }
        exit;
    }

    
    public function updateArticle()
    {
        // Vérifier si l'utilisateur est administrateur
        if (empty($_SESSION['user']) || $_SESSION['user']['is_admin'] !== 1) {
            header("Location: index.php?ctrl=accueil&action=index");
            exit;
        }
    
        // Récupérer l'ID de l'article depuis l'URL
        $articleId = isset($_GET['id']) ? intval($_GET['id']) : null;
    
        if ($articleId) {
            // Récupérer l'article actuel
            $article = $this->articleModel->getArticleById($articleId);
    
            if ($article) {
                // Sauvegarder l'article dans l'historique
                $historySaved = $this->articleModel->saveArticleToHistory($article);
                if (!$historySaved) {
                    echo "Erreur lors de la sauvegarde de l'article dans l'historique.";
                    exit;
                }
    
                // Passer les données de l'article à la vue
                $this->dataArray['article'] = $article;
                $this->render("update_article_view");
            } else {
                echo "Article introuvable.";
            }
        } else {
            header("Location: index.php?ctrl=article&action=portfolio");
        }
    }
    

    
    public function saveArticle()
    {
        // Vérification utilisateur administrateur
        if (empty($_SESSION['user']) || $_SESSION['user']['is_admin'] !== 1) {
            header("Location: index.php?ctrl=accueil&action=index");
            exit;
        }
    
        // Préparation des données de l'article
        $articleData = [
            'A_ID' => $_POST['A_ID'],
            'A_Titre' => $_POST['A_Titre'],
            'A_Contenu' => $_POST['A_Contenu'],
            'A_Pays' => $_POST['A_Pays'],
        ];
    
        // Gestion des fichiers (image principale)
        $articleData['A_Image'] = !empty($_FILES['A_Image']['name']) 
            ? $_FILES['A_Image']['name'] 
            : $_POST['old_A_Image'];
    
        // Gestion des fichiers (images optionnelles)
        for ($i = 2; $i <= 9; $i++) {
            $fileKey = 'A_Images'; // Nom des fichiers envoyés en tableau
            $oldKey = "old_A_Image$i"; // Ancienne valeur de l'image
            $articleData["A_Image$i"] = !empty($_FILES[$fileKey]['name'][$i - 2]) 
                ? $_FILES[$fileKey]['name'][$i - 2] 
                : ($_POST[$oldKey] ?? null); // Utilise l'ancienne valeur si aucune nouvelle n'est fournie
        }
    
        // Sauvegarde l'article dans l'historique avant mise à jour
        $this->articleModel->saveArticleToHistory($articleData['A_ID']);
    
        // Met à jour l'article avec les nouvelles données
        $updated = $this->articleModel->updateArticle($articleData);
    
        if ($updated) {
            header("Location: index.php?ctrl=article&action=portfolio&msg=updated");
        } else {
            echo "Erreur lors de la mise à jour de l'article.";
        }
        exit;
    }
    



}
