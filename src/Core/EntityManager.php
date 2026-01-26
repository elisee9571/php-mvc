<?php

namespace App\Core;

use ReflectionClass;

class EntityManager
{
    private ?Database $db;

    /**
     * On stocke les objets "en attente" d'être sauvegardés
     */
    private array $toPersist = [];

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * persist() = "je veux sauvegarder cet objet"
     * (mais je n'exécute pas encore la requête SQL)
     */
    public function persist(object $entity): void
    {
        $this->toPersist[] = $entity;
    }

    /**
     * flush() = exécute vraiment les requêtes SQL
     */
    public function flush(): void
    {
        foreach ($this->toPersist as $entity) {
            $this->save($entity);
        }

        // On vide la liste après sauvegarde
        $this->toPersist = [];

        $this->db = null;
    }

    private function save(object $entity): void
    {
        $reflection = new ReflectionClass($entity);
        $table = strtolower($reflection->getShortName());

        $data = [];
        foreach ($reflection->getProperties() as $property) {
            $name = $property->getName(); // ex: "username"
            $getter = 'get' . ucfirst($name); // => "getUsername"

            // Si le getter n'existe pas, on ignore cette propriété
            if (!$reflection->hasMethod($getter)) {
                continue;
            }

            // Si la méthode n'est pas publique, on ignore
            $method = $reflection->getMethod($getter);
            if (!$method->isPublic()) {
                continue;
            }

            // Appelle le getter et stocke la valeur dans le tableau
            $data[$name] = $entity->$getter();
        }

        // On ne veut pas enregistrer "id" dans un INSERT/UPDATE
        unset($data['id']);

        if ($entity->getId() === null) {
            $columns = array_keys($data);               // ex: ['username','email','password']
            $fields = implode(', ', $columns);          // "username, email, password"
            $marks = ':' . implode(', :', $columns);    // ":username, :email, :password"

            $stmt = $this->db->prepare("INSERT INTO {$table} ({$fields}) VALUES ({$marks})");
            $stmt->execute($data);

            // Récupère l'id auto-incrémenté
            $entity->setId((int)$this->db->lastInsertId());
            return;
        }

        $columns = array_keys($data);
        $setParts = [];

        foreach ($columns as $col) {
            $setParts[] = "{$col} = :{$col}";
        }

        $setClause = implode(', ', $setParts);

        $stmt = $this->db->prepare("UPDATE {$table} SET {$setClause} WHERE id = :id");

        $data['id'] = $entity->getId(); // pour le WHERE
        $stmt->execute($data);
    }
}