<?php

// 1. On charge le parent et le modèle
require_once __DIR__ . '/AbstractManager.php';
require_once __DIR__ . '/../models/Project.php';

// 2. On ajoute l'héritage "extends"
class ProjectManager extends AbstractManager
{
    // --- PLUS BESOIN de private PDO $db; ---
    // --- PLUS BESOIN de public function __construct() ---

    public function findAll() : array
    {
        // On utilise $this->db qui vient d'AbstractManager
        $stmt = $this->db->prepare('SELECT * FROM projects ORDER BY created_at DESC');
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $projects = [];
        foreach ($results as $row) {
            $projects[] = new Project(
                $row['title'],
                $row['description'],
                $row['github_url'],
                $row['live_url'],
                $row['media_url'] ?? '',
                $row['id'],
                $row['created_at']
            );
        }
        return $projects;
    }

    public function findOne(int $id) : ?Project
    {
        $stmt = $this->db->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        return new Project(
            $row['title'],
            $row['description'],
            $row['github_url'],
            $row['live_url'],
            $row['media_url'] ?? '',
            $row['id'],
            $row['created_at']
        );
    }

    public function create(Project $project) : void
    {
        $stmt = $this->db->prepare('
            INSERT INTO projects (title, description, github_url, live_url, media_url)
            VALUES (:title, :description, :github_url, :live_url, :media_url)
        ');
        $stmt->execute([
            ':title'       => $project->getTitle(),
            ':description' => $project->getDescription(),
            ':github_url'  => $project->getGithubUrl(),
            ':live_url'    => $project->getLiveUrl(),
            ':media_url'   => $project->getMediaUrl(),
        ]);
    }

    public function update(Project $project) : void
    {
        $stmt = $this->db->prepare('
            UPDATE projects 
            SET title = :title, description = :description, 
                github_url = :github_url, live_url = :live_url,
                media_url = :media_url
            WHERE id = :id
        ');
        $stmt->execute([
            ':title'       => $project->getTitle(),
            ':description' => $project->getDescription(),
            ':github_url'  => $project->getGithubUrl(),
            ':live_url'    => $project->getLiveUrl(),
            ':media_url'   => $project->getMediaUrl(),
            ':id'          => $project->getId(),
        ]);
    }

    public function delete(int $id) : void
    {
        $stmt = $this->db->prepare('DELETE FROM projects WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}