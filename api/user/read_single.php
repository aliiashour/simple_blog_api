<?php

    
    header('Access-Control-Allow-Origin: *') ; 
    header('Content-Type: application/json') ; 

    include_once "../../config/Database.php";
    include_once "../../models/User.php";

    $database = new Database() ; 
    $db = $database->connect() ; 

    $user = new User($db) ; 
    if(isset($_GET['id']) && is_numeric($_GET['id'])){

        $res = $user->read_single($_GET['id']) ; 
    
        if($res->rowCount()){
            $user_arr= array() ; 
            $user_arr['users'] = array() ; 
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                extract($row) ; 
                $user_item = array(
                    'user_id' => $user_id,
                    'user_name' => $user_uname,
                    'user_full_name' => $user_name,
                    'user_emil' => $user_email,
                    'user_image' => $user_image
                );
                array_push($user_arr['users'], $user_item) ; 
            }
            echo json_encode($user_arr) ; 
        }else{
            echo json_encode(array('not-found'=> 'there are no user with this id')) ; 
        }
    }else{
        echo json_encode(array('un-valid'=>'enter vaild numeric user id')) ; 
    }



?>