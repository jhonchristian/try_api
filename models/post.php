<?php
    class Post 
    {
        // DB Stuff
        private $conn;
        private $table = 'posts';

        // Post Properties
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        // Constractor with DB

        public function __construct($db)
        {
            $this->conn = $db;
        }

        // Get POsts
        public function read()
        {
            // Create Query
            $query = 'SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                    FROM '
                    . $this->table . ' p
                    LEFT JOIN
                    categories c ON p.category_id = c.id
                    ORDER BY
                    p.created_at DESC';
            
            // Create prepared statements
            $stmt = $this->conn->prepare($query);

            // Execute Query
            $stmt->execute();
            
            return $stmt;
        }

        // Get Single Post
        public function read_single()
        {
            // Create Query
            $query = 'SELECT 
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                    FROM '
                    . $this->table . ' p
                    LEFT JOIN
                    categories c ON p.category_id = c.id
                    WHERE
                    p.id = ?
                    LIMIT 0,1';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Property
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        }

        // Create Post
        public function create()
        {
            $query = 'INSERT INTO ' . $this->table . '
                    SET
                        title = :title,
                        body = :body,
                        author = :author,
                        category_id = :category_id';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind param
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->title);
            $stmt->bindParam(':category_id', $this->category_id);

            // Execute Query
            if($stmt->execute())
            {
                return true;
            }
            // Print error if something goes wrong
            print_f('Error: %s.\n ', $stmt->error);
            return false;
        }
    }
?>