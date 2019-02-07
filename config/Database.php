<?php 
    class Database
    {
        // DB params
        private $host     = 'localhost';
        private $db_name  = 'try_api';
        private $username = 'root';
        private $password = '';
        private $conn     = null;

        // DB Connect
        public function connect()
        {
            $this->conn = null;
            try 
            {
                $database = 'mysql:host='.$this->host
                          . ';dbname='   .$this->db_name;
                $this->conn = new PDO($database, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch ( PDOException $e)
            {
                echo 'Connection Error: '.$e->getMessage();
            }

            return $this->conn;
        }
    }
?>