<?php
require_once ('data/connection.php');

class Authentication{
   
    public function getLogin(){
        $db = Db::getInstance();
        $req = $db->prepare('SELECT * FROM users WHERE use_username = :username');
        $req->execute(array('username' => $_REQUEST['username']));
        $query = $req->fetch();
        
        if(isset($_REQUEST['username'])&&isset($_REQUEST['password'])){
            
            if($_REQUEST['username'] == $query['use_username'] && $_REQUEST['password'] == $query['use_password']){
                $_SESSION['userId'] = $query['peo_id'];
                return TRUE;
            } 
            else {
                return FALSE;
            }
        }
    } 
}
?>