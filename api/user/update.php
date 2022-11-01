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
        $data = json_decode(file_get_contents("php://input")) ; 
        $user->user_id = $_GET['id'] ; 
        $user->user_uname = $data->user_uname;
        $user->user_name = $data->user_name;
        $user->user_email = $data->user_email;
        $user->user_password = sha1($data->user_password);

        if($user->update($_GET['id'])){
            echo json_encode(
                array("success"=> "user updated successfully")
            ) ; 
        }else{
            echo json_encode(
                array("error"=>"can not update user, this ID is not found or this user name found already")
            ) ; 
        }
    }else{
        echo json_encode(array("error"=>"enter valid number")) ; 
    }