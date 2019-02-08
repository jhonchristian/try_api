<?php
    
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Category.php');

    // Instantiate DB
    $database = new Database();
    $db = $database->connect();

    // Create Object
    $category = new Category($db);

    // Get the result of query
    $result = $category->read();

    // Count if rows exist
    if($result->rowCount() > 0)
    {
        // Create Category Array Data
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $array_item = array (
                'id' => $id,
                'name' => $name,
                'created_at' => $created_at
            );

            // Push to 'data'
            array_push($posts_arr['data'], $array_item);
        }
    }
    
    // Turn to JSON
    echo json_encode($posts_arr);
?>