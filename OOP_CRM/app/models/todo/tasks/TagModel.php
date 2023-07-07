<?php

namespace OOP_CRM\app\models\todo\tasks;

use OOP_CRM\app\models\Database;
use PDO;
use PDOException;

class TagModel
{
    private bool|null|PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->getInstance();
        try {
            $sql = "SELECT 1 FROM `tags` LIMIT 1";
            $this->db->query($sql);
        } catch (PDOException $exception) {
            $this->createTable();
        }
    }

    public function createTable(): bool
    {
        $sql_tags = "CREATE TABLE IF NOT EXISTS `tags` (
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT(11) NOT NULL,
        `name` VARCHAR(255) NOT NULL
        );";

        $sql_tags_tasks = "CREATE TABLE IF NOT EXISTS `task_tags` (
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `task_id` INT(11) NOT NULL,
        `tags_id` INT(11) NOT NULL
        );";

        try {
            $this->db->prepare($sql_tags)->execute();
            $this->db->prepare($sql_tags_tasks)->execute();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function getTagsByTask(int $id): array|bool
    {
        $sql = "SELECT * FROM `tags`
                JOIN `task_tags` ON tags.id = task_tags.tags_id 
                WHERE task_tags.task_id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$id]);
            return $query->fetchAll(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }
    public function getAllTags(): array|bool
    {
        $sql = "SELECT * FROM `tags`";
        try {
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function removeAllTaskTags(int $id): bool
    {
        $sql = "DELETE FROM `task_tags` WHERE task_id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$id]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function removeUnusedTags(int $tag_id): bool
    {
        $sql = "SELECT COUNT(*) FROM `task_tags` WHERE tags_id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$tag_id]);
            $count = $query->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
            if ($count == 0) {
                $sql = "DELETE FROM `tags` WHERE id = ?";
                $query = $this->db->prepare($sql);
                $query->execute([$tag_id]);
            }
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getTagByNameAndUser(string $tag_name, int $id): array|bool
    {
        $sql = "SELECT * FROM tags WHERE name = ? AND user_id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$tag_name, $id]);
            return $query->fetch(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }
    public function getTagNameById(int $tagId, int $id): string|bool
    {
        $sql = "SELECT tags.name FROM `tags` WHERE tags.id = ? AND tags.user_id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$tagId, $id]);
            $tag = $query->fetch(\PDO::FETCH_ASSOC) ?? false;
            return $tag['name'] ?? '';
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function addTag(string $tag_name, int $id): int|bool
    {
        $sql = "INSERT INTO tags(name, user_id) VALUES (?, ?)";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$tag_name, $id]);
            return $this->db->lastInsertId() ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function addTaskTag(int $task_id, int $tag_id): bool
    {
        $sql = "INSERT INTO task_tags(task_id, tags_id) VALUES (?,?)";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$task_id, $tag_id]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }


}