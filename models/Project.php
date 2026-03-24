<?php
class Project
{
    public function __construct(
        private string $title,
        private string $description,
        private string $githubUrl,
        private string $liveUrl,
        private string $mediaUrl = '',
        private ?int $id = null,
        private ?string $createdAt = null
    ) {}

    public function getId() : ?int { return $this->id; }
    public function getTitle() : string { return $this->title; }
    public function getDescription() : string { return $this->description; }
    public function getGithubUrl() : string { return $this->githubUrl; }
    public function getLiveUrl() : string { return $this->liveUrl; }
    public function getMediaUrl() : string { return $this->mediaUrl; }
    public function getCreatedAt() : ?string { return $this->createdAt; }

    public function setTitle(string $title) : void { $this->title = $title; }
    public function setDescription(string $description) : void { $this->description = $description; }
    public function setGithubUrl(string $githubUrl) : void { $this->githubUrl = $githubUrl; }
    public function setLiveUrl(string $liveUrl) : void { $this->liveUrl = $liveUrl; }
    public function setMediaUrl(string $mediaUrl) : void { $this->mediaUrl = $mediaUrl; }
}