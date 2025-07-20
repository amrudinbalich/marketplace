<?php

namespace App\Models;

use Amrudinbalic\Marketplace\Database\Model;
use PDO;

class User extends Model
{
    public function get(int $id): array
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): void
    {
        $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function update(int $id, array $data): void
    {
        $sql = 'UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function delete(int $id): void
    {
        $sql = 'DELETE FROM users WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}