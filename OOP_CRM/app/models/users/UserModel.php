<?php

namespace OOP_CRM\app\models\users;

use OOP_CRM\app\models\Database;
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

    public function tableExist(string $tableName): bool|array
    {
        $sql = "SELECT COUNT(*) FROM ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$tableName]);
            return $query->fetchColumn() > 0 ?? false;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function createTable(): bool
    {
        $sql_roles = "CREATE TABLE IF NOT EXISTS `roles` (
        `id` INT(11) NULL AUTO_INCREMENT PRIMARY KEY,
        `role_name` VARCHAR(255) NOT NULL,
        `role_description` TEXT
        )";

        $sql_users = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `email_verify` TINYINT(1) NOT NULL DEFAULT 0,
    `password` VARCHAR(255) NOT NULL,
    `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
    `role` INT(11) DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `last_login` TIMESTAMP NULL,
    `date_of_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (`role`) REFERENCES `roles`(`id`)
    )";

        try {
            $this->db->prepare($sql_roles)->execute();
            $this->db->prepare($sql_users)->execute();

            //insert roles if it's they are not exist!!
            if (!$this->tableExist('roles')) {
                $sql = "INSERT INTO `roles` (`role_name`, `role_description`) VALUES 
                           ('Subscriber', 'Can only read post and leave some comments to it but can not create something by his owned'),
                           ('Author', 'Can create his own content also can publish it but can`t edit else`s content'),
                           ('Contributor', 'Can create his own content but can`t publish it until Admin or Redactor allow this action'),
                           ('Editor', 'Have access to publish controls also has rights to control pages and other content on site.Editor can also control comments like(ban or allow comment)'),
                           ('Administrator', 'Has absolute access to all functionalities of web-site like users control, plugins control and posts control and else...')";
                try {
                    $this->db->prepare($sql)->execute();
                    return true;
                } catch (PDOException $exception) {
                    return false;
                }
            }
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
            $role = $data['role'];
            $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
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

        $sql = "DELETE FROM `users` where users.id={$id}";
        try {
            $this->db->prepare($sql)->execute();
            return true;
        } catch (PDOException) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }

    }

    public function updateUser(int $id, string $email, int $role, string $username): bool
    {
        $admin = !empty($userData['is_admin']) && $userData['is_admin'] !== 0 ? 1 : 0;
        $active = isset($userData['is_active']) ? 1 : 0;
        $sql = "UPDATE `users` SET users.username='$username',
                 users.email='$email',
                 users.role = '$role',
                 users.is_active = '$active',
                 users.is_admin = '$admin' WHERE users.id={$id}";
        try {
            $this->db->prepare($sql)->execute();
            return true;
        } catch (PDOException) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function readUser(int $id): array|bool
    {
        $sql = "SELECT * FROM `users` WHERE users.id={$id}";
        try {
            $query = $this->db->prepare($sql);
            $query->execute();
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
