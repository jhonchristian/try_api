<?php

    class Category
    {
        // DB Stuff
        private $conn;
        private $table = 'categories';

        // Category Properties
        public $id;
        public $name;
        public $created_at;

        // Constractor with DB
        public function __construct($db)
        {
            $this->conn = $db;
        }

        // Get All Categories
        public function read()
        {
            // Create Query
            $query = 'SELECT * FROM '.$this->table.' ORDER BY name ASC';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute Query
            if($stmt->execute())
            {
                return $stmt;
            }
            else 
            {
                printf('Error: %s.\n',$stmt->error);
                return false;
            }
        }

        // Get Single Categories
        public function read_single()
        {
            // Create query
            $query = 'SELECT * FROM '.$this->table.' WHERE id = :id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Parameters
            $stmt->bindParam(':id', $this->id);

            // Execute
            if($stmt->execute())
            {
                return true;
            }
            else 
            {
                printf('Error: %s.\n', $stmt->error);
                return false;
            }
        }
    }
?>