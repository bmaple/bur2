<?php
require_once('User.php');
require_once('check.php');
$user = isLoggedIn();
if(!$user->isAdmin()){
    header("location:index.php");
    exit;
}
if(isset($_POST['submit'])){
    if($user->addGroup()){
        $_SESSION['user'] = serialize($user);
        header("location:groups.php");
        exit;
    }
}    
?>
<html>
<head>
<title>Register</title>
</head>
<body>
<form id ='groupForm' action='groups.php' method='post' accept-charset='UTF-8'>
<label for='groupName'>New Group Name</label>
<input type='text' name='groupName' id='groupName' /><br />
<input type='submit' name='submit' id='submit'value='submit' />
</form>
</body> 
</html>
