<?php

namespace InternetShop\app\models\users;

use InternetShop\app\models\Database;
use PDO;
use PDOException;

class UserModel
{
    private bool|null|PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->getInstance();
        try {
            $sql = "SELECT 1 FROM users LIMIT 1";
            $this->db->query($sql);
        } catch (PDOException $exception) {
            $this->createTable();
        }
    }

    public function createTable(): bool
    {

        $sql_users = "CREATE TABLE IF NOT EXISTS `users` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `email_verify` TINYINT(1) NOT NULL DEFAULT 0,
            `password` VARCHAR(255) NOT NULL,
            `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
            `last_login` TIMESTAMP NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
    )";

        try {
            $this->db->prepare($sql_users)->execute();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function readAll(): array|bool
    {
        try {
            $query = $this->db->query("SELECT * FROM users");
            return $query->fetchAll() ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function readAllId(): array|bool
    {
        try {
            $query = $this->db->query("SELECT users.id FROM users");
            return $query->fetchAll(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function createUser(array $data): bool
    {
        try {
            $username = $data['username'];
            $password = $data['password'];
            $email = $data['email'];
            $role = $data['is_admin'];
            $sql = "INSERT INTO users (username, password, email, is_admin) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), $email, $role]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function deleteUser(int $id): bool
    {

        $sql = "DELETE FROM `users` where users.id = ?";
        try {
            $this->db->prepare($sql)->execute([$id]);
            return true;
        } catch (PDOException) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }

    }

    public function updateUser(int $id, string $email, int $is_admin, string $username): bool
    {
        $admin = !empty($userData['is_admin']) && $userData['is_admin'] !== 0 ? 1 : 0;
        $active = isset($userData['is_active']) ? 1 : 0;
        $sql = "UPDATE `users` SET users.username = ?,
                 users.email = ?,
                 users.is_admin = ? WHERE users.id = ?";
        try {
            $this->db->prepare($sql)->execute([$username,$email,$is_admin,$id]);
            return true;
        } catch (PDOException) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function readUser(int $id): array|bool
    {
        $sql = "SELECT * FROM `users` WHERE users.id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getAllUsersPagination(int $offset, int $limit): array|bool
    {
        $sql = "SELECT * FROM `users` LIMIT $limit OFFSET {$offset}";
        try {
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }
}
