<?php


    class Post{
        private $con  ; 
        private $tbl = 'posts' ; 

        //post properities
        public $post_id ; 
        public $post_title ; 
        public $post_content ; 
        public $post_publisher ; 
        public $post_image ; 
        public $post_time ; 
        public $post_reader_count ; 


        // constructore

        public function __construct($db)
        {
            $this->con = $db ; 
        }

        public function read(){
            $q= "SELECT users.user_name,
                users.user_id,
                post_id,
                post_title,
                post_content,
                post_image,
                post_time,
                post_visitor_count as post_readers_count
                FROM " . $this->tbl . " INNER JOIN users
                ON post_publisher = user_id
                ORDER BY post_time DESC" ; 
            $stmt = $this->con->prepare($q);
            $stmt->execute() ; 
            return $stmt ; 
        }
        public function read_single($post_id){
            $q= "SELECT users.user_name,
                users.user_id,
                post_id,
                post_title,
                post_content,
                post_image,
                post_time,
                post_visitor_count as post_readers_count
                FROM " . $this->tbl . " INNER JOIN users
                ON post_publisher = user_id
                WHERE post_id = ". $post_id ." ORDER BY post_time DESC" ; 
            $stmt = $this->con->prepare($q);
            $stmt->execute() ; 
            return $stmt ; 
        }

        public function create(){
            //check if publisher found

            $q = "SELECT * FROM users WHERE user_id = ?" ; 
            $stmt = $this->con->prepare($q) ;
            $this->post_publisher =htmlspecialchars(strip_tags($this->post_publisher)) ;
            $stmt->execute(array(
                $this->post_publisher
            )) ; 
            if(!$stmt->rowCount()) return false ; 

            $q = "INSERT INTO " . $this->tbl . "(post_title, post_content, post_publisher) VALUES(?, ?, ?)" ; 
            $stmt = $this->con->prepare($q) ;
            $this->post_title = htmlspecialchars(strip_tags($this->post_title)) ;
            $this->post_content =htmlspecialchars(strip_tags($this->post_content)) ; 
            $this->post_publisher =is_numeric($this->post_publisher) ? $this->post_publisher: 'x' ;
            $bool = $stmt->execute(array(
                $this->post_title,
                $this->post_content, 
                $this->post_publisher
            )) ; 
            if(!$bool){
                return false ; 
            }
            return true ; 
        }


        public function update($post_id){

                $q = "SELECT * FROM users WHERE user_id = ?" ; 
                $stmt = $this->con->prepare($q) ;
                $this->post_publisher =htmlspecialchars(strip_tags($this->post_publisher)) ;
                $stmt->execute(array(
                    $this->post_publisher
                )) ; 
                if(!$stmt->rowCount()) return false ; 
                
                $q = "SELECT * FROM ". $this->tbl ." WHERE post_id = ?" ; 
                $stmt = $this->con->prepare($q) ;
                $stmt->execute(array($post_id)) ; 
                if(!$stmt->rowCount()) return false ; 


                $q = "UPDATE " . $this->tbl . " SET post_title=?, post_content=?, post_publisher=?, post_image=?, post_visitor_count=? WHERE post_id = ?" ; 
                $stmt = $this->con->prepare($q);
                $this->post_title = htmlspecialchars(strip_tags($this->post_title)) ; 
                $this->post_content = htmlspecialchars(strip_tags($this->post_content)) ; 
                $this->post_image = htmlspecialchars(strip_tags($this->post_image)) ;  
                $this->post_reader_count = htmlspecialchars(strip_tags($this->post_reader_count)) ; 
                $bool = $stmt->execute(
                    array($this->post_title, $this->post_content, $this->post_publisher, $this->post_image, $this->post_reader_count, $post_id)
                ) ; 
                
                if(!$bool){
                    return false ; 
                }
                return true ; 
        }

        public function delete($post_id){

            $q = "SELECT * FROM ". $this->tbl ." WHERE post_id = ?" ; 
            $stmt = $this->con->prepare($q) ;
            $stmt->execute(array($post_id)) ; 
            if(!$stmt->rowCount()) return false ; 

            $q = "DELETE FROM " . $this->tbl . " WHERE post_id = ?" ; 
            $stmt = $this->con->prepare($q);
            $bool = $stmt->execute(
                array($post_id)
            ) ; 
            
            if(!$bool){
                return false ; 
            }
            return true ; 
        }
    }


?>