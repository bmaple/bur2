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

<label for="username">Username: </label>
<input type='text' name='username' id='username' maxlength='20' /> <br />

<label for="password">Password: </label>
<input type='password' name='password' id='password' maxlength='20' /> <br />
<label for="passCopy">Password: </label>
<input type='password' name='passCopy' id='passCopy' maxlength='20' /> <br />
<label for="group">group: </label>
<?php

echo "<select name ='group'>";
$user->dbConnection = new mysqli(          
    $user->mysql['host'],                  
    $user->mysql['username'],              
    $user->mysql['password'],              
    $user->mysql['database'],              
    $user->mysql['port']);                 
$group_query = "select * from groups";
$result = mysqli_query($user->dbConnection, $group_query);
while( $row = mysqli_fetch_assoc($result)){
    echo "\n<option value ='{$row['GroupID']}'>\n";
        echo"{$row['GroupName']}\n";
        echo "</option>\n";
}
mysqli_close($user->dbConnection);
echo"</select><br />\n<input type='submit' name='submit' id='submit'value='submit' /> </form> </body> </html>";
?>
