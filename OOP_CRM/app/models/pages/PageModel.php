<?php

namespace OOP_CRM\app\models\pages;

use OOP_CRM\app\models\Database;
use PDO;
use PDOException;

class PageModel
{
    private bool|null|PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->getInstance();
        try {
            $sql = "SELECT 1 FROM `pages`";
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
            return $query->fetchColumn() > 0;
        } catch (PDOException $exception) {
            return false;
        }
    }
    public function createTable(): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS `pages` (
        `id` INT(11) NULL AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `slug` VARCHAR(255) NOT NULL,
        `role` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        try {
            $this->db->prepare($sql)->execute();

            //insert all pages if they isn't set
            if (!$this->tableExist('pages')) {
                $this->insertPages();
            }
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function getAllPages(): array|bool
    {
        $sql = "SELECT * FROM `pages`";
        try {
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function readAllId(): array|bool
    {
        try {
            $query = $this->db->query("SELECT pages.id FROM `pages`");
            return $query->fetchAll(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function insertPages(): bool
    {
        $insertPagesSql = "INSERT INTO `pages` (`title`, `slug`, `role`, `created_at`, `updated_at`) VALUES 
                           ('PagesDelete', 'pages/delete', '4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('RolesPage', 'roles', '4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('PageEdit', 'pages/edit', '4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('PageCreation', 'pages/create', '4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('UsersPage', 'users', '3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('UsersCreate', 'users/create', '5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('UsersEdit', 'users/edit', '5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('UsersDelete', 'users/delete', '5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('RolesCreate', 'roles/create', '5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('RolesEdit', 'roles/edit', '4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('RolesDelete', 'roles/delete', '5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('HomePage', '/', '1,2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('TodoCategory', 'todo/category', '2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('TodoCategoryEdit', 'todo/category/edit', '2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('TodoCategoryDelete', 'todo/category/delete', '2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('TodoCategoryCreate', 'todo/category/create', '2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('TodoList', 'todo/tasks', '2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('TodoTaskCreate', 'todo/tasks/create', '2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('TodoTaskEdit', 'todo/tasks/edit', '2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('TodoTaskDelete', 'todo/tasks/delete', '2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('PagePagination', 'pages/index', '3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('UsersPagination', 'users/index', '3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('TaskTag', 'todo/tasks/byTag', '2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('UserTask', 'todo/tasks/task', '1,2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('CompletedTaskDelete', 'todo/tasks/completed/delete', '2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21'),
                           ('ExpiredTaskDelete', 'todo/tasks/expired/delete', '2,3,4,5', '2023-06-08 09:12:20', '2023-06-08 09:12:21')";
        try {
            $this->db->exec($insertPagesSql);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getAllPagesPagination(int $offset, int $limit): array|bool
    {
        $sql = "SELECT * FROM `pages` LIMIT $limit OFFSET $offset";
        try {
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getPageById(int $id): array|bool
    {
        $sql = "SELECT * FROM `pages` WHERE pages.id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getPageBySlug(string $slug): array|bool
    {
        $sql = "SELECT * FROM `pages` WHERE pages.slug = ? ";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$slug]);
            return $query->fetch(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getPageBySlugCheck(string $slug, int $id): array|bool
    {
        $sql = "SELECT * FROM `pages` WHERE pages.slug = ? AND pages.id != ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$slug, $id]);
            return $query->fetch(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }


    public function createPage(string $title, string $slug, string $roles): bool
    {
        $sql = "INSERT INTO pages(title, slug, role) VALUES (?, ?, ?)";

        try {
            $query = $this->db->prepare($sql);
            $query->execute([$title, $slug, $roles]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function deletePage(int $id): bool
    {
        $sql = "DELETE FROM `pages` WHERE pages.id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$id]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function updatePage(string $title, string $slug, string $roles, int $id): bool
    {
        $sql = "UPDATE `pages` SET pages.title = ?, pages.slug = ?, pages.role = ? 
                WHERE pages.id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$title, $slug, $roles, $id]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

}