<?php

require_once __DIR__ . '/AbstractManager.php';
require_once __DIR__ . '/../models/User.php';

class UserManager extends AbstractManager 
{
    public function findByName(string $name): ?User
    {
        // On cherche dans la colonne "name" (vue sur ta capture Neon)
        $stmt = $this->db->prepare('SELECT * FROM public.users WHERE name = :name');
        $stmt->execute([':name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        // ATTENTION : Vérifie l'ordre dans ton models/User.php !
        // Si ton constructeur est (name, role, password, id), alors :
        return new User(
            $row['name'],
            $row['role'],
            $row['password'],
            $row['id']
        );
    }
}