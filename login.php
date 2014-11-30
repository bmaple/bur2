<?php
require_once(user.php);
if(isset($_POST['submit'])){
    if($user->login()){
        $user->RedirectToURL();
    }
}
?>
<html>
<head>
<title> </title>
<head>
<body>
<form id ='login' action='login.php' method='post' accept-charset='UTF-8'>
<input type='text' name='username' id='username' maxlength='20' />
<input type='password' name='password' id='password' maxlength='20' />
<input type='submit' name='submit' id='submit' />
</form>
</body>
</html>
