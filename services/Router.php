<?php
require_once __DIR__ . '/../controllers/ProjectController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

class Router {
    private ProjectController $pc;
    private AuthController $ac;

    public function __construct() {
        $this->pc = new ProjectController();
        $this->ac = new AuthController();
    }

    public function handleRequest() : void {
        $route = $_GET['route'] ?? '';
        $isAdmin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

        if (in_array($route, ['create', 'check_create', 'update', 'check_update', 'delete'])) {
            if (!$isAdmin) {
                header('Location: index.php?route=login');
                exit;
            }
        }

        if ($route === 'show') {
            $this->pc->show();
        } elseif ($route === 'create') {
            $this->pc->create();
        } elseif ($route === 'check_create') {
            $this->pc->checkCreate();
        } elseif ($route === 'update') {
            $this->pc->update();
        } elseif ($route === 'check_update') {
            $this->pc->checkUpdate();
        } elseif ($route === 'delete') {
            $this->pc->delete();
        } elseif ($route === 'login') {
            $this->ac->login();
        } elseif ($route === 'check_login') {
            $this->ac->checkLogin();
        } elseif ($route === 'logout') {
            $this->ac->logout();
        } else {
            $this->pc->list();
        }
    }
}