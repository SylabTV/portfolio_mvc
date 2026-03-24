<?php

// 1. On charge le parent et le modèle
require_once __DIR__ . '/AbstractManager.php';
require_once __DIR__ . '/../models/User.php';

class UserManager extends AbstractManager 
{
    // On change le nom ici pour que AuthController puisse la trouver
    public function findByName(string $name): ?User
    {
        // On utilise la colonne "name" (vue sur ta capture Neon)
        $stmt = $this->db->prepare('SELECT * FROM public.users WHERE name = :name');
        $stmt->execute([':name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        // On crée l'objet User avec les données de ta table
        return new User(
            $row['name'],
            $row['role'] ?? 'admin',
            $row['password'],
            $row['id']
        );
    }
}