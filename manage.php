<?php
require_once('User.php');
require_once('check.php');
$user = isLoggedIn();
if(isset($_POST['submit'])){
    if($user->manage()){
        $_SESSION['user'] = serialize($user);
        header("location:manage.php");
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
$user_query = "select UserID, Username from users";
$user->openDbConnection();
$result = mysqli_query($user->dbConnection, $user_query);
echo "<label for='user'>Select a user to modify</label>\n
    <select name='user' id='user'>";
while( $row = mysqli_fetch_assoc($result)){
    echo "<option value ='{$row['UserID']}'>";
    echo"{$row['UserID']} - {$row['Username']}";
    echo "</option>\n";
}
echo "</select><br />";
$result = mysqli_query($user->dbConnection, $group_query);
echo "<select name='group' id='group'>";
echo "<option value='null'>No group</option>";
while( $row = mysqli_fetch_assoc($result)){
    echo "\n<option value ='{$row['GroupID']}'>\n";
    echo"{$row['GroupName']}\n";
    echo "</option>\n";
}
mysqli_close($user->dbConnection);
?>
</select>
<input type='checkbox' name='chGroup' id='chGroup' value='chGroup' /> 
<label for="chGroup">Verify change of group</label>
<br/>
<input type='checkbox' name='promote' id='promote' value='promote' /><br/>
<input type='submit' name='submit' id='submit'value='submit' />
</form>
</body> 
</html>
