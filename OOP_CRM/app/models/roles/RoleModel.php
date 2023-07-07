<?php

namespace OOP_CRM\app\models\roles;

use OOP_CRM\app\models\Database;
use PDO;
use PDOException;

class RoleModel
{
    private bool|null|PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->getInstance();
        try {
            $sql = "SELECT 1 FROM `roles` LIMIT 1";
            $this->db->query($sql);
        } catch (\PDOException $exception) {
            $this->createTable();
        }
    }

    public function createTable(): bool
    {
        $sql = "CREATE TABLE IF NOT EXISTS `roles` (
        `id` INT(11) NULL AUTO_INCREMENT PRIMARY KEY,
        `role_name` VARCHAR(255) NOT NULL,
        `role_description` TEXT
        )";

        try {
            $this->db->prepare($sql)->execute();
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function getAllRoles(): array|bool
    {
        $sql = "SELECT * FROM `roles`";
        try {
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getAllRolesByName(string $role_name, int $id): array|bool
    {
        $sql = "SELECT * FROM `roles` WHERE roles.role_name = ? AND roles.id != ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$role_name, $id]);
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function readAllId(): array|bool
    {
        try {
            $query = $this->db->query("SELECT roles.id FROM `roles`");
            return $query->fetchAll(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function getRoleById(int $id): array|bool
    {
        $sql = "SELECT * FROM `roles` WHERE roles.id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$id]);
            return $query->fetch(\PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function createRole(string $roleName, string $roleDescription): bool
    {
        $sql = "INSERT INTO roles(role_name, role_description) VALUES (?,?)";

        try {
            $query = $this->db->prepare($sql);
            $query->execute([$roleName, $roleDescription]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function deleteRole(int $id): bool
    {
        $sql = "DELETE FROM `roles` WHERE roles.id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$id]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }


    public function updateRole(string $roleName, string $roleDescription, int $id): bool
    {
        $sql = "UPDATE `roles` SET roles.role_name = ?, roles.role_description = ? 
                WHERE roles.id = ?";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([$roleName, $roleDescription, $id]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

}