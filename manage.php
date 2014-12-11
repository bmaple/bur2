<?php
require_once('header.php');
//$user = isLoggedIn();
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
}
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
        <?php
        if($user->isAdmin()) {
            echo "<li class='active'> <a href='manage.php'><i class='fa fa-fw fa-wrench'></i> Manage Groups and Users</a> </li>";
            echo "<li> <a href='groups.php'><i class='fa fa-fw fa-plus'></i> Create a New Group</a> </li>";
        }
        ?>
        <!--<li>
        <a href="search.php"><i class="fa fa-fw fa-search"></i> Search Files</a>
        </li>-->
    </ul>
</div>
<!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">
<?php
$group_query = "select * from groups";
$user_query = "select UserID, Username from users";
$user->openDbConnection();
$result = mysqli_query($user->dbConnection, $user_query);
?>
<form id ='register' action='manage.php' method='post' accept-charset='UTF-8'>
    <div class="container-fluid">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <h1>Manage Groups and Users</h1>
        <div class="row">
<?php
$group_query = "select * from groups";
$user_query = "select UserID, Username from users";
$user->openDbConnection();
$result = mysqli_query($user->dbConnection, $user_query);
?>
        </div>
        <!-- /.row -->
        <div class="row">
<?php
echo "<label for='user'>Select a User to Modify</label>\n
    <select class='form-control' name='user' id='user'>";
while( $row = mysqli_fetch_assoc($result)){
    echo "<option value ='{$row['UserID']}'>";
    echo"{$row['UserID']} - {$row['Username']}";
    echo "</option>\n";
}
echo "</select><br />";
?>
        </div>

        <!-- /.row -->
        <div class="row">
<?php
$result = mysqli_query($user->dbConnection, $group_query);
echo "<label for='group'>Select a Group </label>";
echo "<select class='form-control' name='group' id='group'>";
echo "<option >No Group</option>";
while( $row = mysqli_fetch_assoc($result)){
    echo "\n<option value ='{$row['GroupID']}'>\n";
    echo"{$row['GroupName']}\n";
    echo "</option>\n";
}
echo"</select><br>";
mysqli_close($user->dbConnection);
?>
        </div>
        <!-- /.row -->
        <div class="row">
            <label for="promote">Promote User to Admin</label>
            <input type='checkbox' name='promote' id='promote' class="checkbox-inline" value='promote' /><br/>
        </div>
        <!-- /.row -->
        <div class="row">
            <label for="chGroup">Verify Change of Group</label>
            <input type='checkbox' name='chGroup' id='chGroup' class="checkbox-inline" value='chGroup' /> 
             <br/>
        </div>
        
        
        <!-- /.row -->
        <div class="row">
            <input type='submit' name='submit' id='submit' value='Submit' />
        </div>
        <!-- /.row -->
        </div>
    </div>
    <!-- /.container-fluid -->
</form>
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
