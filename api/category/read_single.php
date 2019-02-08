<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Category.php');

    // Instantiate DB
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $category = new Category($db);

    // Check if there is an ID
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get single post
    $category->read_single();

    // Create an Array
    $post_arr = array();
    $post_arr['data'] = array(
        'id' => $category->id,
        'name' => $category->name,
        'created_at' => $category->created_at
    );

    echo json_encode($post_arr);
?>