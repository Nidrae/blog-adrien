<?php
// bdd.php - Gestion de la connexion à la base de données

class Bdd {
    private $host = 'localhost:3306';  // Adresse du serveur de base de données
    private $dbname = 'Blog_adrien';  // Nom de la base de données
    private $username = 'root';  // Utilisateur de la base de données
    private $password = 'admin';  // Mot de passe de l'utilisateur
    private $pdo;

    // Constructeur qui établit la connexion
    public function __construct() {
        try {
            // DSN (Data Source Name) pour MariaDB
            $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            // Configuration de l'attribut PDO pour les erreurs
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Si une erreur se produit, on l'affiche
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Méthode pour récupérer la connexion PDO
    public function getConnexion() {
        return $this->pdo;
    }

    // Méthode pour fermer la connexion
    public function closeConnexion() {
        $this->pdo = null;
    }
}
?>
