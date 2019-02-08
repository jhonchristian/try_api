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

        // Create Category
        public function create()
        {
            // Create Query
            $query = 'INSERT INTO '.$this->table.' SET name = :name';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->name = htmlspecialchars(strip_tags($this->name));

            // Bind Parameter
            $stmt->bindParam(':name', $this->name);

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

        // Update Categery 
        public function update()
        {
            $query = 'UPDATE '.$this->table.' SET name = :name WHERE id = :id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->name  = htmlspecialchars(strip_tags($this->name));
            $this->id  = htmlspecialchars(strip_tags($this->id));
            
            // Bind Param
            $stmt->bindParam(':name', $this->name);
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

        // Delete Categery 
        public function delete()
        {
            $query = 'DELETE FROM '.$this->table.' WHERE id = :id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));
            
            // Bind Param
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