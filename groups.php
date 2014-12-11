<?php
//require_once('User.php');
//require_once('check.php');
require_once('header.php');
//$user = isLoggedIn();
if(!$user->isAdmin()){
    header("location:index.php");
    exit;
}
if(isset($_POST['submit'])){
    if($user->addGroup()){
        $_SESSION['user'] = serialize($user);
        header("location:groups.php");
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
                        echo "<li> <a href='manage.php'><i class='fa fa-fw fa-wrench'></i> Manage Groups and Users</a> </li>";
                        echo "<li class='active'> <a href='groups.php'><i class='fa fa-fw fa-plus'></i> Create a New Group</a> </li>";
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

            <div class="container-fluid">

                <div class="row">
                	<div class="col-lg-4"></div>
                    <div class="col-lg-4">
                    	<h1>Create a New Group</h1>
						<form id ='groupForm' action='groups.php' method='post' accept-charset='UTF-8'>
						<label for='groupName'>New Group Name: </label>
						<input type='text' name='groupName' id='groupName' maxlength='20' /><br />
						<input type='submit' name='submit' id='submit'value='Submit' />
						</form>

                    </div>
                    
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
