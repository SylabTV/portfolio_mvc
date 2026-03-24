<?php

abstract class AbstractManager
{
    protected PDO $db;

    public function __construct()
    {
        // 1. On récupère les variables (getenv marche pour Render ET le .env chargé)
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT') ?: '5432';
        $name = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');

        // 2. LE TRUC CRUCIAL POUR NEON : sslmode=require
        // Sans ça, Neon refuse la connexion à distance
        $dsn = "pgsql:host=$host;port=$port;dbname=$name;sslmode=require";
        
        try {
            $this->db = new PDO($dsn, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $e) {
            // On affiche l'erreur réelle pour savoir ce qui foire (à enlever en prod)
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}