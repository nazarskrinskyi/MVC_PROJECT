<?php

namespace OOP_CRM\app\models\todo\tasks;

use OOP_CRM\app\models\Database;
use PDO;
use PDOException;

class TaskModel
{
    private bool|null|PDO $db;

    private int $user_id;

    public function __construct()
    {
        $this->user_id = $_SESSION['user_id'] ?? 0;
        $this->db = (new Database())->getInstance();
        try {
            $sql = "SELECT 1 FROM `todo_list` LIMIT 1";
            $this->db->query($sql);
        } catch (PDOException $exception) {
            $this->createTable();
        }
    }

    public function createTable(): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS `todo_list` (
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT(11) NOT NULL,
        `title` VARCHAR(255) NOT NULL,
        `description` TEXT,
        `category_id` INT NOT NULL,
        `status` ENUM('new', 'in_progress', 'completed', 'on_hold', 'cancelled') NOT NULL,
        `priority` ENUM('low', 'medium', 'high', 'urgent') NOT NULL,
        `assigned_to` INT,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `finish_date` DATETIME,
        `completed_at` DATETIME,
        `reminder_at` DATETIME
         )";
        try {
            $this->db->prepare($sql)->execute();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function getAllTasks(): array|bool
    {

        $status = 'completed';
        $sql = "SELECT * FROM `todo_list` where todo_list.user_id = ? and todo_list.finish_date > NOW() and todo_list.status != ? ORDER BY todo_list.finish_date ASC";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$this->user_id, $status]);
            return $query->fetchAll(\PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function readAllId(): array|bool
    {
        try {
            $query = $this->db->prepare("SELECT todo_list.id FROM `todo_list` where todo_list.user_id = ?");
            $query->execute([$this->user_id]);
            return $query->fetchAll(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getAllExpiredTasks(): array|bool
    {
        $status = 'completed';
        $sql = "SELECT * FROM `todo_list` where todo_list.user_id = ? and todo_list.finish_date < NOW() and todo_list.status != ? ORDER BY todo_list.finish_date ASC";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$this->user_id, $status]);
            return $query->fetchAll(\PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getAllCompletedTasks(): array|bool
    {
        $status = 'completed';
        $sql = "SELECT * FROM `todo_list` WHERE todo_list.user_id = ? AND todo_list.status = ? ORDER BY todo_list.finish_date ASC";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$this->user_id, $status]);
            return $query->fetchAll(\PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getTaskById(int $id): array|bool
    {
        $sql = "SELECT * FROM `todo_list` WHERE todo_list.id = ? AND todo_list.user_id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$id, $this->user_id]);
            return $query->fetch(\PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getTaskByIdAndUserId(int $task_id, int $userId): array|bool
    {
        $sql = "SELECT * FROM `todo_list` WHERE todo_list.id = ? and todo_list.user_id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$task_id, $userId]);
            return $query->fetch(\PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getTasksByTagId(int $tagId, int $userId): array|bool
    {
        $sql = "SELECT * FROM `todo_list` 
                JOIN  `task_tags` ON todo_list.id = task_tags.task_id
                WHERE task_tags.tags_id = ? and todo_list.user_id = ? ORDER BY todo_list.finish_date ASC";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$tagId, $userId]);
            return $query->fetchAll(\PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function createTask(array $data): bool
    {
        $sql = "INSERT INTO todo_list(user_id, title, category_id, status, priority, finish_date, description) VALUES (?,?,?,?,?,?,?)";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([
                $data['user_id'],
                $data['title'],
                $data['category_id'],
                $data['status'],
                $data['priority'],
                $data['finish_date'],
                $data['description']
            ]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function deleteTask(int $id): bool
    {
        $sql_1 = "DELETE FROM `task_tags` WHERE task_tags.task_id = ?";
        $sql_2 = "DELETE FROM `todo_list` WHERE todo_list.id = ?";
        try {
            $query_1 = $this->db->prepare($sql_1);
            $query_1->execute([$id]);
            $query_2 = $this->db->prepare($sql_2);
            $query_2->execute([$id]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function updateTask(array $data, int $id): bool
    {

        $sql = "UPDATE `todo_list` SET 
                             todo_list.title = ?,
                             todo_list.description = ?,
                             todo_list.status = ?, 
                             todo_list.category_id = ?, 
                             todo_list.priority = ?, 
                             todo_list.finish_date = ?,
                             todo_list.reminder_at = ?
                WHERE todo_list.id = ?";

        try {
            $query = $this->db->prepare($sql);
            $query->execute([
                $data['title'],
                $data['description'],
                $data['status'],
                $data['category_id'],
                $data['priority'],
                $data['finish_date'],
                $data['reminder'],
                $id
            ]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function updateTaskStatus(int $id, string $status, string $datetime): bool
    {
        $sql = "UPDATE `todo_list` SET todo_list.status = ?";
        try {
            if ($datetime !== null) {
                $sql .= ", todo_list.completed_at = ? WHERE todo_list.id = ?";
                $query = $this->db->prepare($sql);
                $query->execute([$status, $datetime, $id]);
            } else {
                $sql .= " WHERE todo_list.id = ?";
                $query = $this->db->prepare($sql);
                $query->execute([$status, $id]);
            }
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }


}