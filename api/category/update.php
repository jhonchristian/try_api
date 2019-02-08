<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once('../../config/Database.php');
    include_once('../../models/Category.php');

    // Instantiate DB
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $category = new Category($db);

    // Get Raw data
    $data = json_decode(file_get_contents("php://input"));

    $category->name = $data->name;
    $category->id = $data->id;

    // Update Post
    if($category->update())
    {
        echo json_encode(
            array(
                'message' => 'Category updated'
            )
        );
    }
    else 
    {
        echo json_encode(
            array(
                'message' => 'Category updated'
            )
        );
    }
?>