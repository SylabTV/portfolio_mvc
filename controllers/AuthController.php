<?php

require_once __DIR__ . '/../managers/UserManager.php';

class AuthController {
    
    private UserManager $userManager;

    public function __construct() {
        // On instancie le manager pour pouvoir chercher l'utilisateur en BDD
        $this->userManager = new UserManager();
    }

    /**
     * Affiche la page de connexion
     */
    public function login(): void {
        $pageTitle = "Connexion Admin";
        // On appelle la vue du formulaire
        require __DIR__ . '/../templates/auth/login.php';
    }

    /**
     * Vérifie les identifiants envoyés par le formulaire
     */
    public function checkLogin(): void {
        // 1. On vérifie si les champs sont remplis
        if (!empty($_POST['name']) && !empty($_POST['password'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];

            // 2. On cherche l'utilisateur dans la base de données
            $user = $this->userManager->findByName($name);

            // 3. Si l'utilisateur existe et que le mot de passe est correct
            if ($user && password_verify($password, $user->getPassword())) {
                
                // On ouvre la session admin
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['user_name'] = $user->getName();
                $_SESSION['user_role'] = $user->getRole();

                // Redirection vers la liste des projets (ton ancre #projets)
                header('Location: index.php#projets');
                exit;
            }
        }

        // Si ça échoue, on renvoie vers le login avec un message d'erreur
        header('Location: index.php?route=login&error=invalid');
        exit;
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout(): void {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}