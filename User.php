<?php
class User {
    var $username;
    var $groupId;
    private $priv;
    private $id;
    private $password;
    var $dbConnection;
    private $randSess = "aer23fwef";
    var $errors = array();
    var $mysql = array(  
        'host' => 'bur.ccg2fbosv7le.us-west-2.rds.amazonaws.com',
        'port' => '3306',
        'database' => 'Bureaucrat',
        'username' => 'bmaple',
        'password' => 'security');
    function openDbConnection(){
        $this->dbConnection = new mysqli(
            $this->mysql['host'], 
            $this->mysql['username'], 
            $this->mysql['password'], 
            $this->mysql['database'], 
            $this->mysql['port']);    
    }
    function getId(){
        return $this->id;
    }
    function RedirectToURL(){
        header("location: $url");
    }
    function checkLogin(){
        $thisSess = $this->GetLoginSessionVar();
        if(empty($_SESSION[$thisSess]))
            return false;
        return true;
    }
    function addGroup(){
        if(empty($_POST['groupName'])){
            return false;
        }
        $this->openDbConnection();
        if($this->dbConnection->connect_errno){
            mysqli_close($this->dbConnection); 
            return false;
        }
        if(isset($_POST['groupName'])){
            $group_insert = "INSERT INTO groups (GroupName) VALUES('{$_POST['groupName']}')";
            if(!$result = mysqli_query($this->dbConnection, $group_insert)) {
                print ("<p>Could not execute query</p>");
                die(mysqli_error($this->dbConnection));    
            }
        }
        return true;
    }
    function manage(){
        if (empty($_POST['group'])){
            //$this->HandleError("Please enter a password");
            return false;
        }
        $this->openDbConnection();
        if($this->dbConnection->connect_errno){
            mysqli_close($this->dbConnection); 
            return false;
        }
        if(isset($_POST['chGroup'])){
            $group_insert = "INSERT INTO groupmembers (UserID, GroupID) VALUES('{$_POST['user']}', '{$_POST['group']}')";
            //            mysqli_query($this->dbConnection, $group_insert);
            if(!$result = mysqli_query($this->dbConnection, $group_insert)) {
                print ("<p>Could not execute query</p>");
                die(mysqli_error($this->dbConnection));    
            }
        }
        if(isset($_POST['promote'])){
            $promote_query = "update users set UserLevel='admin' where UserID='{$_POST['user']}'";
            if(!$result = mysqli_query($this->dbConnection, $promote_query)) {
                print ("<p>Could not execute query</p>");
                die(mysqli_error($this->dbConnection));    
            }
        }
        mysqli_close($this->dbConnection); 
        return true;
    }
    function register(){
        if (empty($_POST['username'])) {
            //$this->HandleError("Please enter a username");
            return false;
        }
        if (empty($_POST['password'])) {
            //$this->HandleError("Please enter a password");
            return false;
        }
        if (empty($_POST['passCopy']) && $_POST['password'] !== $_POST['passCopy']) {
            //$this->HandleError("Please enter a password");
            //return false;
        }
        $this->openDbConnection();
        if($this->dbConnection->connect_errno){
            mysqli_close($this->dbConnection); 
            return false;
        }
        $this->username = $_POST['username'];
        $this->password = $_POST['password'];
        if(!$this->regAuth()) {
            mysqli_close($this->dbConnection); 
            return false;
        }
        session_start();
        $id_query = "select UserID from users where username='$this->username';";
        if(!$result = mysqli_query($this->dbConnection, $id_query)) {
            //print ("<p>Could not execute query</p>");
            //die(mysqli_error($this->dbConnection));    
        }
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $this->id = $row["UserID"]; 
        mysqli_close($this->dbConnection); 
        $_SESSION['user'] = serialize($this);
        $_SESSION[$this->GetLoginSessionVar()] = $this->username;
        return true;
    }
    function regAuth(){
        $regAuth_query="insert into users (username, password) 
            values ('$this->username', '$this->password');";
        mysqli_query($this->dbConnection, $regAuth_query);
        return true;
    }
    function login(){
        if (empty($_POST['username'])) {
            //$this->HandleError("Please enter a username");
            return false;
        }
        if (empty($_POST['password'])) {
            //$this->HandleError("Please enter a password");
            return false;
        }
        $this->username = $_POST['username'];
        $this->password = $_POST['password'];
        if(!$this->auth()) {
            return false;
        }
        //session_start();
        $id_query = "select UserID, UserLevel from users where username='$this->username';";
        $result = mysqli_query($this->dbConnection, $id_query);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $this->id = $row["UserID"];
        $this->priv = $row["UserLevel"]; 
        mysqli_close($this->dbConnection); 
        $_SESSION['user'] = serialize($this);
        $_SESSION[$this->GetLoginSessionVar()] = $this->username;
        return true;
    }
    function isAdmin(){
        if( $this->priv == "admin")
            return true;
        else false;
    }
    function GetLoginSessionVar() {
        return md5($this->randSess);
    }
    function auth(){
        $this->openDbConnection();
        if($this->dbConnection->connect_errno){
            return false;
        }
        $auth_query="select password from users where username='$this->username'";
        $result = mysqli_query($this->dbConnection, $auth_query);
        $row = mysqli_fetch_row($result);
        echo $row[0];
        //mysqli_close($this->dbConnection); 
        if($this->password == $row[0])
            return true;
        return false;
    }
}
?>
