<?php

class ProjectController
{
    private ProjectManager $manager;

    public function __construct()
    {
        $this->manager = new ProjectManager();
    }

    /**
     * Verrou de sécurité pour l'admin
     */
    private function checkAdmin(): void
    {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: index.php?route=login');
            exit;
        }
    }

    public function list()
    {
        $projects = $this->manager->findAll();
        require_once __DIR__ . '/../templates/layout/header.php';
        require_once __DIR__ . '/../templates/projects/list.php';
        require_once __DIR__ . '/../templates/layout/footer.php';
    }

    public function show()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $project = $this->manager->findOne($id);

        if (!$project) {
            header('Location: index.php');
            exit;
        }

        require_once __DIR__ . '/../templates/layout/header.php';
        require_once __DIR__ . '/../templates/projects/show.php';
        require_once __DIR__ . '/../templates/layout/footer.php';
    }

    public function create()
    {
        $this->checkAdmin();
        require_once __DIR__ . '/../templates/layout/header.php';
        require_once __DIR__ . '/../templates/projects/create.php';
        require_once __DIR__ . '/../templates/layout/footer.php';
    }

    public function checkCreate()
    {
        $this->checkAdmin();
        $mediaName = '';
        if (!empty($_FILES['project_file']['name'])) {
            $mediaName = $this->handleUpload($_FILES['project_file']);
        }

        $project = new Project(
            $_POST['title'],
            $_POST['description'],
            $_POST['github_url'],
            $_POST['live_url'] ?? '',
            $mediaName
        );

        $this->manager->create($project);
        header('Location: index.php#projets');
        exit;
    }

    public function update()
    {
        $this->checkAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        $project = $this->manager->findOne($id);

        if (!$project) {
            header('Location: index.php');
            exit;
        }

        require_once __DIR__ . '/../templates/layout/header.php';
        require_once __DIR__ . '/../templates/projects/update.php';
        require_once __DIR__ . '/../templates/layout/footer.php';
    }

    public function checkUpdate()
    {
        $this->checkAdmin();
        $id = (int) $_POST['id'];
        $project = $this->manager->findOne($id);

        if (!$project) {
            header('Location: index.php');
            exit;
        }

        $mediaName = $project->getMediaUrl();

        if (!empty($_FILES['project_file']['name'])) {
            // Suppression de l'ancienne image dans public/img/projects/
            if ($mediaName) {
                $oldFile = __DIR__ . '/../public/img/projects/' . $mediaName;
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }
            $mediaName = $this->handleUpload($_FILES['project_file']);
        }

        $updatedProject = new Project(
            $_POST['title'],
            $_POST['description'],
            $_POST['github_url'],
            $_POST['live_url'] ?? '',
            $mediaName,
            $id 
        );

        $this->manager->update($updatedProject);
        header('Location: index.php#projets');
        exit;
    }

    public function delete()
    {
        $this->checkAdmin();
        $id = (int) ($_GET['id'] ?? 0);
        
        $project = $this->manager->findOne($id);
        if ($project && $project->getMediaUrl()) {
            $file = __DIR__ . '/../public/img/projects/' . $project->getMediaUrl();
            if (file_exists($file)) {
                unlink($file);
            }
        }

        $this->manager->delete($id);
        header('Location: index.php#projets');
        exit;
    }

    private function handleUpload(array $file): string
    {
        // Chemin corrigé vers ton dossier public
        $uploadDir = __DIR__ . '/../public/img/projects/'; 
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $newName = uniqid('project_') . '.' . $extension;
        $targetPath = $uploadDir . $newName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $newName; 
        }
        return '';
    }
}