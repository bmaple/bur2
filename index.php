<?php
require_once('check.php');
$user = isLoggedIn();
?>
<html>
<body>
<h1>Hello <?php $user->username ?>, Just fixing the url cause I'm care too much</H1>
<iframe width="1280" height="720" src="//www.youtube.com/embed/6hcSpSC8T0M?autoplay=1" frameborder="0" allowfullscreen></iframe>

</body>
</html>
