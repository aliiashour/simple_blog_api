<?php

    class Database{
        private $host = "localhost" ; 
        private $dbname = "blog" ; 
        private $user = "root" ; 
        private $pass = "" ; 
        private $option = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        private $con ; 


        public function connect(){
            $this->con = null ;
            try {
                $this->con = new PDO('mysql:host=' . $this->host .';dbname=' . $this->dbname, $this->user, $this->pass, $this->option);
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
            } catch (PDOException $e) {
                echo "Connection Error". $e->getMessage() ; 
            }
            return $this->con ; 
        }

    }


    
?>