<?php

abstract class AbstractManager
{
    // On garde protected pour que UserManager et ProjectManager y accèdent
    protected PDO $db;

    public function __construct()
    {
        // 1. Charger le fichier .env qui est à la racine
        // On remonte d'un cran car AbstractManager est dans le dossier /managers/
        $envPath = __DIR__ . '/../.env';

        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                // On ignore les lignes de commentaires commençant par #
                if (strpos(trim($line), '#') === 0) continue;
                
                // On enregistre la variable dans l'environnement PHP
                putenv(trim($line));
            }
        }

        // 2. Récupérer les variables depuis l'environnement
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $name = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');

        // 3. Connexion PDO dynamique (PostgreSQL)
        $dsn = "pgsql:host=$host;port=$port;dbname=$name";
        
        try {
            $this->db = new PDO($dsn, $user, $pass);
            // On active les erreurs pour le debug
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $e) {
            // Message propre en cas d'erreur de connexion
            die("Problème de connexion à la base de données. Vérifiez votre fichier .env");
        }
    }
}