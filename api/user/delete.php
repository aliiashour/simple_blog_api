<?php

    
    header('Access-Control-Allow-Origin: *') ; 
    header('Content-Type: application/json') ; 
    header('Access-Control-Allow-Methods: POST') ; 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With') ; 
    
    include_once "../../config/Database.php";
    include_once "../../models/User.php";

    $database = new Database() ; 
    $db = $database->connect() ; 

    $user = new User($db) ; 

    if(isset($_GET["id"]) && is_numeric($_GET["id"])){
        $user->user_id = $_GET['id'] ; 

        if($user->delete($_GET['id'])){
            echo json_encode(
                array("success"=> "user deleted successfully")
            ) ; 
        }else{
            echo json_encode(
                array("error"=>"can not delete user, this ID is not found")
            ) ; 
        }
    }else{
        echo json_encode(array("error"=>"enter valid number")) ; 
    }