<?php
require_once('User.php');
session_start();
$user = new User();
if(isset($_POST['submit'])){
    if($user->register()){
        $_SESSION['user'] = serialize($user);
        header("location:index.php");
        exit;
    }
}
?>
<html>
<head>
<title>Register</title>
</head>
<body>
<form id ='register' action='register.php' method='post' accept-charset='UTF-8'>
<?php
$group_query = "select * from groups";
$result = mysqli_query($user->dbConnection, $group_query);
while( $row = mysqli_fetch_assoc($result)){
    echo "\n<option value ='{$row['GroupID']}'>\n";
        echo"{$row['GroupName']}\n";
        echo "</option>\n";
}
mysqli_close($user->dbConnection);
?>
</select><br />
<input type='submit' name='submit' id='submit'value='submit' />
</form>
</body> 
</html>
