<?php

    
    header('Access-Control-Allow-Origin: *') ; 
    header('Content-Type: application/json') ; 
    header('Access-Control-Allow-Methods: POST') ; 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With') ; 
    
    include_once "../../config/Database.php";
    include_once "../../models/POST.php";

    $database = new Database() ; 
    $db = $database->connect() ; 

    $post = new Post($db) ; 

    if(isset($_GET["id"]) && is_numeric($_GET["id"])){
        $data = json_decode(file_get_contents("php://input")) ; 
        $post->post_id = $_GET['id'] ; 
        $post->post_title = $data->post_title;
        $post->post_content = $data->post_content;
        $post->post_image = $data->post_image;
        $post->post_publisher = is_numeric($data->post_publisher) ?$data->post_publisher : 'x' ;
        $post->post_reader_count = $data->post_reader_count;

        if($post->update($_GET['id'])){
            echo json_encode(
                array("success"=> "post updated successfully")
            ) ; 
        }else{
            echo json_encode(
                array("error"=>"can not update post, this ID is not found or this publisher id is not found")
            ) ; 
        }
    }else{
        echo json_encode(array("error"=>"enter valid number")) ; 
    }