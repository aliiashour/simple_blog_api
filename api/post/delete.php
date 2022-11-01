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

    if(isset($_GET["id"]) && is_numeric($_GET["id"])){
        $post->post_id = $_GET['id'] ; 

        if($post->delete($_GET['id'])){
            echo json_encode(
                array("success"=> "post deleted successfully")
            ) ; 
        }else{
            echo json_encode(
                array("error"=>"can not delete post, this ID is not found")
            ) ; 
        }
    }else{
        echo json_encode(array("error"=>"enter valid number")) ; 
    }