<?php

    header('Access-Control-Allow-Origin: *') ; 
    header('Content-Type: application/json') ; 

    include_once "../../config/Database.php";
    include_once "../../models/Post.php";

    $database = new Database() ; 
    $db = $database->connect() ; 
    $post = new Post($db) ; 

    $res = $post->read() ;
    $num = $res->rowCount() ; 
    if($num){
        $post_arr = array() ; 
        $post_arr['posts'] = array() ; 
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
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
        echo json_encode(array('message'=>'no posts')) ; 
    }

?>