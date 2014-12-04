<?php
require_once('check.php');
$user = isLoggedIn();
if(isset($_GET['logout']))
    logout($user);
?>
<html>
<body>
<h1>Hello <?php echo $user->getId()?>, Just fixing the url cause I'm care too much</H1>
<a style="font-size:34; float:right" href="index.php?logout=true">Logout</a><br/>
<iframe width="1280" height="720" src="https://www.youtube.com/watch?v=dh6RB1RT9i0" frameborder="0" allowfullscreen></iframe>

</body>
</html>
