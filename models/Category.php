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

            // Execute first so we can fetch the data
            if($stmt->execute())
            {
                // Fetch Value
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Set Property
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->created_at = $row['created_at'];
            }
            else 
            {
                prinf("Error %s.\n", $stmt->error);
                return false;
            }
        }
    }
?>