<?php
require_once('User.php');
$user = new User();
if(isset($_POST['submit'])){
    if($user->login()){
        $user->RedirectToURL(landing.php);
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
<input type='submit' name='submit' id='submit' />
</form>
</body>
</html>
