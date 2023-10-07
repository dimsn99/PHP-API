<?php
    class DBConnect {
        private $server_name = "127.0.0.1:5306";
        private $database_name = "TheiaDB";
        private $user_name = "root";
        private $password = "GenorayTheia";
        public $conn;

        public function getConnection() {
            $this->conn = null;
            try {
                $this->conn = new PDO("mysql:host=" . $this->server_name . 
                ";dbname=" . $this->database_name, $this->user_name, $this->password);
                $this->conn->query("SELECT CURDATE() AS date FROM DUAL");
                echo "connection success ";
            } catch(PDOException $exception) {
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }
?>

