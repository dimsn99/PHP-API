<?php
    class DBConnect {
        private $serverName = "127.0.0.1:5306";
        private $databaseName = "TheiaDB";
        private $userName = "root";
        private $password = "GenorayTheia";
        public $conn;

        public function getConnection() {
            $this->conn = null;
            try {
                $this->conn = new PDO("mysql:host=" . $this->serverName . 
                ";dbname=" . $this->databaseName, $this->userName, $this->password);
                $this->conn->query("SELECT CURDATE() AS date FROM DUAL");
                echo "connection success ";
            } catch(PDOException $exception) {
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }
?>

