<?php

namespace App\Repository;

use App\Core\Database;
use App\Model\User;

class UserRepository
{
    private ?Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @info Récupère tous les utilisateurs
     * @return array<string, array<string, mixed>>
     */
    public function findAll(?array $criteria = []): array
    {
        $size = (int)isset($criteria['size']) ? $criteria['size'] : 5;
        $page = (int)isset($criteria['page']) ? $criteria['page'] : 1;
        $offset = ($page - 1) * $size;

        $stmt = $this->db->prepare("SELECT * FROM user LIMIT :limit OFFSET :offset");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class); // Partie : 2
        $stmt->execute([
            'limit' => $size,
            'offset' => $offset
        ]);

        $users = $stmt->fetchAll();
        $count = (int)$this->db->query("SELECT COUNT(*) FROM user")->fetchColumn();

        $this->db = null; // fermeture de la connexion

        return [
            'users' => $users,
            'count' => $count
        ];
    }

    /**
     * @info Récupère un utilisateur par son ID
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class); // Partie : 2
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch();

        $this->db = null; // fermeture de la connexion
        return $user;
    }

    /**
     * @info Récupère un utilisateur par son Email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class); // Partie : 2
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch();

        $this->db = null; // fermeture de la connexion
        return $user;
    }

    /**
     * @info Récupère tous les utilisateurs correspondant à une recherche
     * @return array<string, array<string, mixed>>
     */
    public function findBySearch(string $q, ?array $criteria = []): ?array
    {
        $size = (int)isset($criteria['size']) ? $criteria['size'] : 5;
        $page = (int)isset($criteria['page']) ? $criteria['page'] : 1;
        $offset = ($page - 1) * $size;
        $like = "%{$q}%";

        $stmt = $this->db->prepare("SELECT * FROM user WHERE username LIKE :q1 OR email LIKE :q2 LIMIT :limit OFFSET :offset");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, User::class); // Partie : 2
        $stmt->execute([
            'q1' => $like,
            'q2' => $like,
            'limit' => $size,
            'offset' => $offset
        ]);

        $countStmt = $this->db->prepare("SELECT COUNT(*) FROM user WHERE username LIKE :q1 OR email LIKE :q2");
        $countStmt->execute([
            'q1' => $like,
            'q2' => $like
        ]);

        $users = $stmt->fetchAll();
        $count = (int)$countStmt->fetchColumn();

        $this->db = null; // fermeture de la connexion

        return [
            'users' => $users,
            'count' => $count
        ];
    }
}
