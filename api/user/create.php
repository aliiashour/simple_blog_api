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
    $data = json_decode(file_get_contents("php://input")) ; 
    $user->user_uname = $data->user_uname;
    $user->user_name = $data->user_name;
    $user->user_email = $data->user_email;
    $user->user_password = sha1($data->user_password);

    if($user->create()){
        echo json_encode(
            array("success"=> "user created successfully")
        ) ; 
    }else{
        echo json_encode(
            array("error"=>"can not insert user, it already inserted before")
        ) ; 
    }
