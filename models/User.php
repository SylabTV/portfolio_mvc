<?php
class User {
    private ?int $id;
    private string $name;
    private string $role;
    private string $password;

    public function __construct(string $name, string $role, string $password, ?int $id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->role = $role;
        $this->password = $password;
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getRole(): string { return $this->role; }
    public function getPassword(): string { return $this->password; }
}