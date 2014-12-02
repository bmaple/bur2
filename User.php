<?php
class User {
    var $username;
    var $password;
    var $dbConnection;
    var $randSess = "aer23fwef";
    var $errors = array();
    var $mysql = array(  
        'host' => 'bur.ccg2fbosv7le.us-west-2.rds.amazonaws.com',
        'port' => '3306',
        'database' => 'Bureaucrat',
        'username' => 'bmaple',
        'password' => 'security');
    function RedirectToURL(){
        header("location: $url");
    }
    function checkLogin(){
        $thisSess = $this->GetLoginSessionVar();
        if(empty($_SESSION[$thisSess]))
            return false;
        return true;
    }
    function login(){
        if (empty($_POST['username']))
        {
            //$this->HandleError("Please enter a username");
            return false;
        }
        if (empty($_POST['password']))
        {
            //$this->HandleError("Please enter a password");
            return false;
        }
        $this->username = $_POST['username'];
        $this->password = $_POST['password'];
        if(!$this->auth())
        {
            return false;
        }
        session_start();
        $_SESSION[$this->GetLoginSessionVar()] = $this->username;
        return true;
    }
    //function HandleError($error) {
    //$this->error_message    
    //}
    function GetLoginSessionVar()
    {
        return md5($this->randSess);
    }
    function auth(){
        $this->dbConnection = new mysqli(
            $this->mysql['host'], 
            $this->mysql['username'], 
            $this->mysql['password'], 
            $this->mysql['database'], 
            $this->mysql['port']);                      
        if($this->dbConnection->connect_errno){
            return false;
        }
        $auth_query="select password from users where username='$this->username'";
        $result = mysqli_query($this->dbConnection, $auth_query);
        $row = mysqli_fetch_row($result);
        echo $row[0];
        mysqli_close($this->dbConnection); 
        if($this->password == $row[0])
            return true;
        return false;
    }
}
?>
