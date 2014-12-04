<?php
require_once('check.php');
$user = isLoggedIn();
if(isset($_GET['logout']))
    logout($user);
?>
<html>
<body>
<h1>Hello <?php $user->username ?>, Just fixing the url cause I'm care too much</H1>
<a style="font-size:34; float:right" href="index.php?logout=true">Logout</a><br/>
<iframe width="1280" height="720" src="//www.youtube.com/embed/6hcSpSC8T0M?autoplay=1" frameborder="0" allowfullscreen></iframe>

</body>
</html>
