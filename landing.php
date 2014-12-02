<?php
require_once('check.php');
$user = isLoggedIn();
?>
<html>
<body>
<h1>TEST</H1>
<p> <?php echo $user->username; ?> </p>
</body>
</html>
