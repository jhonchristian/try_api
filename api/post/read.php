<?php
    //  Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Post.php');

    // Instantiate DB
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $post = new Post($db);

    // Blog post query
    $result = $post->read();

    // Get row count
    $cnt = $result->rowCount();

    // Check if any posts
    if($cnt > 0)
    {
        // Post array
        $post_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

            $post_item = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_n ame' => $category_name
            );
            
            // Push to 'data' 
            array_push($post_arr['data'], $post_item);
        }

        // Turn it to JSON & output
        echo json_encode($post_arr);
    }
    else 
    {
        // No Posts
        echo json_encode(
            array('message' => 'No Posts Found')
        );
    }
?>