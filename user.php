<?php
class user {
    $username;
    $password;
    $dbConnection;
    $mysql = array(  'host' => 'bur.ccg2fbosv7le.us-west-2.rds.amazonaws.com',
        'port' => '3306',
        'database' => 'Bureaucrat',
        'username' => 'bmaple',
        'password' => 'security',);
    function login(){
        if (!empty($_POST['username']))
        {
            $this->HandleError("Please enter a username");
        }
        if (!empty($_POST['password']))
        {
            $this->HandleError("Please enter a password");
        }
        $username($_POST['username']);
        $password($_POST['password']);
        if(!$this->auth($username, $password))
        {
            return false;
        }
        session_start();
        $_SESSION[$this->GetLoginSessionVar()] = $username;
        return true;
    }
    function auth(){
        $dbConnection= new mysqli(
            $mysql['host'], 
            $mysql['username'], 
            $mysql['password'], 
            $mysql['database'], 
            $mysql['port']);                      
        if($dbConnection->connect_errno){
            return false;
        }
        $auth_query="select password from users where username=$username"
            $result = mysqli_query($auth_query);
        mysqli_close($dbConnection); 
        if($password == $result)
            return true;
        return false;
    }
}
?>
