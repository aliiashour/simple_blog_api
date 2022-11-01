<?php

    
    header('Access-Control-Allow-Origin: *') ; 
    header('Content-Type: application/json') ; 

    include_once "../../config/Database.php";
    include_once "../../models/Post.php";

    $database = new Database() ; 
    $db = $database->connect() ; 

    $post = new Post($db) ; 
    if(isset($_GET['id']) && is_numeric($_GET['id'])){

        $res = $post->read_single($_GET['id']) ; 
    
        if($res->rowCount()){
            $post_arr= array() ; 
            $post_arr['posts'] = array() ; 
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                extract($row) ;  
                $post_item = array(
                    'post_id' =>$post_id,
                    'post_title' =>$post_title,
                    'post_content' =>$post_content,
                    'post_publisher_name' =>$user_name,
                    'post_image' =>$post_image,
                    'post_time' =>$post_time,
                    'post_reader_count' =>$post_readers_count
                ) ; 
                array_push($post_arr['posts'], $post_item) ; 
            }
            echo json_encode($post_arr) ; 
        }else{
            echo json_encode(array('not-found'=> 'there are no post with this id')) ; 
        }
    }else{
        echo json_encode(array('un-valid'=>'enter vaild numeric post id')) ; 
    }



?>