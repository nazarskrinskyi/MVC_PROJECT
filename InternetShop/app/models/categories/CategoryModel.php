<?php

namespace InternetShop\app\models\categories;

use InternetShop\app\models\Database;
use PDO;
use PDOException;

class CategoryModel
{
    private bool|null|PDO $db;
    private mixed $user_id;

    public function __construct()
    {
        $this->user_id = $_SESSION['user_id'] ?? null;
        $this->db = (new Database())->getInstance();
        try {
            $sql = "SELECT 1 FROM `categories` LIMIT 1";
            $this->db->query($sql);
        } catch (PDOException $exception) {
            $this->createTable();
        }
    }

    public function createTable(): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS `categories` (
        `id` INT(11) NULL AUTO_INCREMENT PRIMARY KEY,
        `parent_id` INT(11) NOT NULL UNIQUE,
        `name` VARCHAR(255) NOT NULL,
        `description` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP                               
         ) ENGINE = MyISAM;";

        try {
            $this->db->prepare($sql)->execute();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function readAllId(): array|bool
    {
        $sql = "SELECT categories.id FROM `categories`";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$this->user_id]);
            return $query->fetchAll(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getAllCategories(): array|bool
    {
        $sql = "SELECT * FROM `categories`";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$this->user_id]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile(
                ) . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }
    public function getCategoryByTitle(string $title, int $id): array|bool
    {
        $sql = "SELECT * FROM `categories` WHERE categories.name = ? AND categories.id != ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$this->user_id, $title, $id]);
            return $query->fetchAll(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile(
                ) . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getAllActiveCategories(): array|bool
    {
        $sql = "SELECT * FROM `categories` WHERE categories.usability = 1";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$this->user_id]);
            return $query->fetchAll(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile(
                ) . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getCategoryById(int $id): array|bool
    {
        $sql = "SELECT * FROM `categories` WHERE categories.id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$id, $this->user_id]);
            return $query->fetch(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile(
                ) . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function createCategory(string $title, $parent_id, string $description): bool
    {
        $sql = "INSERT INTO categories(name, parent_id, description) VALUES (?,?,?)";

        try {
            $query = $this->db->prepare($sql);
            $query->execute([$title, $parent_id, $description]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function deleteCategory(int $id): bool
    {
        $sql = "DELETE FROM `categories` WHERE categories.id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$id]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile(
                ) . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function updateCategory(string $title, string $description, int $usability, int $id): bool
    {
        $sql = "UPDATE `categories` SET 
                             categories.name = ?,
                             categories.description = ?,
                             categories.usability = ?
                WHERE categories.id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$title, $description, $usability, $id]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile(
                ) . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

}