<?php
require_once('header.php');
$user = isLoggedIn();
if(!$user->isAdmin()){
    header("location:index.php");
    exit;
}
if(isset($_POST['submit'])){
    if($user->manage()){
        $_SESSION['user'] = serialize($user);
        header("location:manage.php");
        exit;
    }
}    //NEED TO HAVE AN ADD GROUP FUNCTION
?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="files.php"><i class="fa fa-fw fa-file"></i> Your Files</a>
                    </li>
                    <li>
                        <a href="upload.php"><i class="fa fa-fw fa-edit"></i> Upload Files</a>
                    </li>
                    <!--<li class="active">
                        <a href="manage.php"><i class="fa fa-fw fa-wrench"></i> Manage Files and Groups</a>
                    </li>
                    <li>
                        <a href="search.php"><i class="fa fa-fw fa-search"></i> Search Files</a>
                    </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
<form id ='register' action='manage.php' method='post' accept-charset='UTF-8'>
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
echo "<label for='group'>select a group </label>";
echo "<select name='group' id='group'>";
echo "<option >No group</option>";
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
<label for="promote">Promote user to admin</label>
<input type='checkbox' name='promote' id='promote' value='promote' /><br/>
<input type='submit' name='submit' id='submit'value='submit' />
</form>

            <div class="container-fluid">

                <div class="row">
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="theme/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="theme/js/bootstrap.min.js"></script>
</body>
</html>