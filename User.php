<?php
class User {
    var $username;
    var $password;
    var $dbConnection;
    var $mysql = array(  'host' => 'bur.ccg2fbosv7le.us-west-2.rds.amazonaws.com',
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
        $this->$username = $_POST['username'];
        $this->$password = $_POST['password'];
        if(!$this->auth())
        {
            return false;
        }
        session_start();
        $_SESSION[$this->GetLoginSessionVar()] = $this->$username;
        return true;
    }
    function auth(){
            $this->$dbConnection= new mysqli(
            $this->$mysql['host'], 
            $this->$mysql['username'], 
            $this->$mysql['password'], 
            $this->$mysql['database'], 
            $this->$mysql['port']);                      
        if($this->$dbConnection->connect_errno){
            return false;
        }
        $auth_query="select password from users where username=$this->$username";
            $result = mysqli_query($auth_query);
        mysqli_close($dbConnection); 
        if($this->$password == $result)
            return true;
        return false;
    }
}
?>
