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
<form id ='register' action='manage.php' method='post' accept-charset='UTF-8'>
<?php
$user->startNewSqli();
$user_query ="select id username from users";
$result = mysqli_query($user->dbConnection, $user_query);
echo "<label for='user'>Select a user to modify<label>";
echo "<select name = 'user' id = 'user'>";
while( $row = mysqli_fetch_assoc($result)){
    echo "\n<option value ='{$row['id']}'>\n";
        echo"{$row['id']} - {$row['username']}";
        echo "</option>\n";
}
echo "</select><br />";
echo "<label for='group'>Select group to add user to <label>";
echo "<select name = 'group' id = 'group'>";
$group_query = "select * from groups";
$result = mysqli_query($user->dbConnection, $group_query);
echo "<option value ='null'>No group </option>";
while( $row = mysqli_fetch_assoc($result)){
    echo "\n<option value ='{$row['GroupID']}'>\n";
        echo"{$row['GroupName']}\n";
        echo "</option>\n";
}
mysqli_close($user->dbConnection);
?>
</select><br />
<label for='promote'>Promote user to manager</label>
<input type='checkbox' name='promote' id='promote'value='promote' /><br />
<input type='submit' name='submit' id='submit'value='submit' />
</form>
</body> 
</html>
