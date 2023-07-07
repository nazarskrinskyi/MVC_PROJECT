<?php

namespace OOP_CRM\app\models\todo\category;
use OOP_CRM\app\models\Database;
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
            $sql = "SELECT 1 FROM `todo_categories` LIMIT 1";
            $this->db->query($sql);
        } catch (PDOException $exception) {
            $this->createTable();
        }
    }

    public function createTable(): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS `todo_categories` (
        `id` INT(11) NULL AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `description` TEXT,
        `usability` TINYINT DEFAULT 1, 
        `user` INT NOT NULL
         )";

        try {
            $this->db->prepare($sql)->execute();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }
    public function readAllId(): array|bool
    {
        $sql = "SELECT todo_categories.id FROM `todo_categories` WHERE todo_categories.user = ?";
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
    public function getAllCategories(): array|bool
    {
        $sql = "SELECT * FROM `todo_categories` WHERE todo_categories.user = ?";
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
        $sql = "SELECT * FROM `todo_categories` WHERE todo_categories.user = ? AND todo_categories.title = ? AND todo_categories.id != ?";
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
        $sql = "SELECT * FROM `todo_categories` WHERE todo_categories.user = ? and todo_categories.usability = 1";
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
        $sql = "SELECT * FROM `todo_categories` WHERE todo_categories.id = ? AND todo_categories.user = ?";
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

    public function createCategory(string $title, string $description, int $user_id): bool
    {
        $sql = "INSERT INTO todo_categories(title, description, user) VALUES (?,?,?)";

        try {
            $query = $this->db->prepare($sql);
            $query->execute([$title, $description, $this->user_id]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile(
                ) . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function deleteCategory(int $id): bool
    {
        $sql = "DELETE FROM `todo_categories` WHERE todo_categories.id = ?";
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
        $sql = "UPDATE `todo_categories` SET 
                             todo_categories.title = ?,
                             todo_categories.description = ?,
                             todo_categories.usability = ?
                WHERE todo_categories.id = ?";
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