<?php

namespace InternetShop\app\models;

use PDO;
use PDOException;

class Database
{
    private static PDO|null $instance = null;
    private string $hostName = DB_HOST;
    private string $userName = DB_USER;
    private string $pass = DB_PASS;
    private string $dbName = DB_NAME;
    private PDO $connection;

    public function __construct()
    {
        try {
            $options =
                [
                    PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];

            $this->connection = new PDO("mysql:host=$this->hostName;dbname=$this->dbName", $this->userName, $this->pass, $options);


        } catch (PDOException $exception) {
            echo "Message->[" . $exception->getMessage() . "] File->[" . $exception->getFile(
                ) . "] Line->[" . $exception->getLine() . "]";
        }
    }

    /**
     * @return PDO|bool
     */
    public function getConnection(): PDO|bool
    {
        try {
            if (isset($this->connection)) {
                return $this->connection;
            }
        }catch (PDOException $exception) {
            exit("You need connect to db at first!! Line->[" . __LINE__ . "]");
        }
        return false;
    }

    /**
     * @return PDO|null
     */
    public function getInstance(): PDO|bool
    {
        if (!self::$instance) {
            $options =
                [
                    PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];

            self::$instance = new PDO(
                "mysql:host=$this->hostName;dbname=$this->dbName",
                $this->userName,
                $this->pass,
                $options
            );
        }

        return self::$instance ?? false;
    }

}