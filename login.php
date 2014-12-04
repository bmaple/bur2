<?php
require_once('User.php');
session_start();
$user = new User();
if(isset($_POST['submit'])){
    if($user->login()){
        $_SESSION['user'] = serialize($user);
        header("location:index.php");
        exit;
    }
}
?>
<html>
<head>
<title> </title>
</head>
<body>
<form id ='login' action='login.php' method='post' accept-charset='UTF-8'>
<label for="username">Username: </label>
<input type='text' name='username' id='username' maxlength='20' /> <br />
<label for="password">Password: </label>
<input type='password' name='password' id='password' maxlength='20' /> <br />
<input type='submit' name='submit' id='submit'value="submit" />
</form>
</body>
</html>
