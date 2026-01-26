<?php

namespace App\Repository;

use App\Core\Database;
use App\Model\User;
use PDO;

class UserRepository
{
    private ?Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @info Récupère tous les utilisateurs
     * @return array<int, array<string, mixed>>
     */
    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM user");
        $rows = $stmt->fetchAll();

        $users = [];
        foreach ($rows as $row) {
            $users[] = $this->mapRowToUser($row);
        }

        $this->db = null; // fermeture de la connexion
        return $users;
    }

    /**
     * @info Récupère un utilisateur par son ID
     * @return array<string, mixed>|null
     */
    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();

        $this->db = null; // fermeture de la connexion
        return $row ? $this->mapRowToUser($row) : null;
    }

    // Partie 2
    /** @param array<string,mixed> $row */
    private function mapRowToUser(array $row): User
    {
        $user = new User();
        $user
            ->setId($row['id'])
            ->setUsername($row['username'])
            ->setEmail($row['email'])
            ->setPassword($row['password']);

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $row = $stmt->fetch();

        $this->db = null; // fermeture de la connexion
        return $row ? $this->mapRowToUser($row) : null;
    }

    public function findBySearch(string $q): ?array
    {
        $like = "%{$q}%";

        $stmt = $this->db->prepare("SELECT * FROM user WHERE username LIKE :q1 OR email LIKE :q2");
        $stmt->execute([
            ':q1' => $like,
            ':q2' => $like
        ]);

        $rows = $stmt->fetchAll();

        $users = [];
        foreach ($rows as $row) {
            $users[] = $this->mapRowToUser($row);
        }

        $this->db = null; // fermeture de la connexion
        return $users;
    }
}
