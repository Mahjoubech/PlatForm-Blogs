<?php

class DatabaseConnection {
    private $host = "localhost";
    private $username = "root";
    private $password = "Mahjoub@123";
    private $database = "blogplatform";
    private $connection;

    public function __construct() {
        $this->connect();
    }
    private function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->username, $this->password);

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            //  echo "Connection successful!";
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            $this->connection = null; // Closing the PDO connection
            echo "Connection closed.";
        }
    }
}


?>
