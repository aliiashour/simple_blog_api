<?php

    class User{
        private $con;
        private $tbl = 'users';

        public $user_id;
        public $user_uname ; 
        public $user_name ; 
        public $user_email ; 
        public $user_image ; 
        public $user_password ; 



        public function __construct($db){
            $this->con = $db ; 
        }

        public function read(){
            $q = "SELECT * FROM " . $this->tbl ; 
            $stmt = $this->con->prepare($q) ; 
            $stmt->execute() ; 
            return $stmt ; 
        }
        
        public function read_single($user_id){
            $q = "SELECT * FROM " . $this->tbl . " WHERE user_id =". $user_id ; 
            $stmt = $this->con->prepare($q) ; 
            $stmt->execute() ; 
            return $stmt ; 
        }

        public function create(){
            
            $q = "SELECT * FROM " . $this->tbl ." WHERE user_uname=?" ; 
            $stmt = $this->con->prepare($q);
            $stmt->execute(array($this->user_uname)) ; 

            if(!$stmt->rowCount()){
                $q = "INSERT INTO " . $this->tbl . "(user_uname, user_name, user_email, user_password) VALUES(?, ?, ?, ?)" ; 
                $stmt = $this->con->prepare($q);
                $this->user_uname = htmlspecialchars(strip_tags($this->user_uname)) ; 
                $this->user_name = htmlspecialchars(strip_tags($this->user_name)) ; 
                $this->user_email = htmlspecialchars(strip_tags($this->user_email)) ; 
                $this->user_password = htmlspecialchars(strip_tags($this->user_password)) ; 
                $bool = $stmt->execute(
                    array($this->user_uname , $this->user_name , $this->user_email, $this->user_password)
                ) ; 
                
                if(!$bool){
                    return false ; 
                }
                return true ; 
            }
            return false ; 
            
        }

        public function update($user_id){
            $this->user_uname = htmlspecialchars(strip_tags($this->user_uname)) ; 

            $q = "SELECT * FROM " . $this->tbl . " WHERE user_uname = ? AND user_id != ?" ; 
            $stmt = $this->con->prepare($q);
            $stmt->execute(array($this->user_uname, $user_id)) ; 

            if(!$stmt->rowCount()){
                
                $q = "SELECT * FROM ". $this->tbl ." WHERE user_id = ?" ; 
                $stmt = $this->con->prepare($q) ;
                $stmt->execute(array($user_id)) ; 
                if(!$stmt->rowCount()) return false ; 

                $q = "UPDATE " . $this->tbl . " SET user_uname=?, user_name=?, user_email=?, user_password=? WHERE user_id = ?" ; 
                $stmt = $this->con->prepare($q);
                $this->user_uname = htmlspecialchars(strip_tags($this->user_uname)) ; 
                $this->user_name = htmlspecialchars(strip_tags($this->user_name)) ; 
                $this->user_email = htmlspecialchars(strip_tags($this->user_email)) ; 
                $this->user_password = htmlspecialchars(strip_tags($this->user_password)) ; 
                $bool = $stmt->execute(
                    array($this->user_uname , $this->user_name , $this->user_email, $this->user_password, $user_id)
                ) ; 
                
                if(!$bool){
                    return false ; 
                }
                return true ; 
            }
            return false ; 
        }

        public function delete($user_id){

            $q = "SELECT * FROM ". $this->tbl ." WHERE user_id = ?" ; 
            $stmt = $this->con->prepare($q) ;
            $stmt->execute(array($user_id)) ; 
            if(!$stmt->rowCount()) return false ; 

            $q = "DELETE FROM " . $this->tbl . " WHERE user_id = ?" ; 
            $stmt = $this->con->prepare($q);
            $bool = $stmt->execute(
                array($user_id)
            ) ; 
            
            if(!$bool){
                return false ; 
            }
            return true ; 
        }
    }

?>