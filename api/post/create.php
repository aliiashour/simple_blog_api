<?php

    
    header('Access-Control-Allow-Origin: *') ; 
    header('Content-Type: application/json') ; 
    header('Access-Control-Allow-Methods: POST') ; 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With') ; 
    
    include_once "../../config/Database.php";
    include_once "../../models/Post.php";

    $database = new Database() ; 
    $db = $database->connect() ; 

    $post = new Post($db) ; 
    $data = json_decode(file_get_contents("php://input")) ; 
    $post->post_title = $data->post_title;
    $post->post_content = $data->post_content;
    $post->post_publisher = $data->post_publisher;

    if($post->create()){
        echo json_encode(
            array("success"=> "post created successfully")
        ) ; 
    }else{
        echo json_encode(
            array("error"=>"can not create post, the publisher is not found")
        ) ; 
    }
