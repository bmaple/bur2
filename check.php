<?php 
require_once('User.php');
function isLoggedIn(){
    session_start();
    if(isset($_SESSION['user'])){
        $user = unserialize($_SESSION['user']);
        if(!$user->checkLogin()){
            header("location:login.php");
            exit;
        }
        return $user;
    }
    else{
            header("location:login.php");
            exit;
    }
}
?>
