<?php

namespace Amrudinbalic\Marketplace\Database;

use PDO;
use PDOException;

class Connect
{
    public ?PDO $pdo = null;

    public function __construct(
        public $port = 3306,
        public $servername = "localhost",
        public $username = 'root',
        public $password = '',
        public $dbname = 'olx_db'
    ) {}


    public function getConnection(): PDO {

        try {

            $dsn =  "mysql:host={$this->servername};port={$this->port};dbname={$this->dbname}";

            $pdo = new \PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $this->pdo = $pdo;

        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }

    }

}