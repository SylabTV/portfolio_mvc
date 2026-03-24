<?php

// 1. On charge le parent et le modèle
require_once __DIR__ . '/AbstractManager.php';
require_once __DIR__ . '/../models/User.php';

class UserManager extends AbstractManager 
{
    public function findByUsername(string $username): ?User
    {
        // Correction : on utilise public.users et la colonne username
        $stmt = $this->db->prepare('SELECT * FROM public.users WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        // On remplit l'objet User avec les bonnes clés de ta base Neon
        return new User(
            $row['username'], // au lieu de 'name'
            $row['role'] ?? 'admin',
            $row['password'],
            $row['id']
        );
    }
}