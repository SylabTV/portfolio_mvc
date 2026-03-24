<?php

// On n'oublie pas de charger le parent !
require_once __DIR__ . '/AbstractManager.php';
require_once __DIR__ . '/../models/User.php';

class UserManager extends AbstractManager 
{
    // PLUS BESOIN de private PDO $db;
    // PLUS BESOIN de __construct() { ... }

    public function findByName(string $name): ?User
    {
        // On utilise directement $this->db qui vient d'AbstractManager
        $stmt = $this->db->prepare('SELECT * FROM users WHERE name = :name');
        $stmt->execute([':name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new User(
            $row['name'],
            $row['role'],
            $row['password'],
            $row['id']
        );
    }
}