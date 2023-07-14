<?php

namespace InternetShop\app\models\auth;

use InternetShop\app\models\Database;
use PDO;
use PDOException;

class AuthUser
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
        $sql_users = "CREATE TABLE `internet_shop`.`users` 
            (`id` INT(11) NOT NULL AUTO_INCREMENT ,
            `username` VARCHAR(100) NOT NULL ,
            `email` VARCHAR(255) NOT NULL ,
            `password` VARCHAR(100) NOT NULL ,
            `is_admin` TINYINT(1) NOT NULL DEFAULT '0' ,
            `last_login` TIMESTAMP NOT NULL ,
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            PRIMARY KEY (`id`), UNIQUE (`email`)) ENGINE = MyISAM;";

        try {
            $this->db->prepare($sql_users)->execute();
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function register(string $username, string $email, string $password, int $is_admin): bool
    {
        $sql = "INSERT INTO users(username, email, password, is_admin) VALUES (?, ?, ?, ?)";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $is_admin]);
            return true;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile() . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

    public function findByEmail(string $email): array|bool
    {
        $sql = "SELECT * FROM `users` WHERE email = ? LIMIT 1";

        try {
            $query = $this->db->prepare($sql);
            $query->execute([$email]);
            return $query->fetch(PDO::FETCH_ASSOC) ?? false;
        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile(
                ) . "] Line->[" . $exception->getLine() . "]";
            return false;
        }
    }

}
