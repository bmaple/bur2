<?php
require_once('header.php');
require_once('User.php');
require_once('check.php');

$user = isLoggedIn();
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

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="files.php"><i class="fa fa-fw fa-file"></i> Your Files</a>
                    </li>
                    <li>
                        <a href="upload.php"><i class="fa fa-fw fa-edit"></i> Upload Files</a>
                    </li>
                    
                    <?php
                    if($user->isAdmin()) {
                        echo "<li> <a href='manage.php'><i class='fa fa-fw fa-wrench'></i> Manage Groups and users</a> </li>";
                        echo "<li> <a href='groups.php'><i class='fa fa-fw fa-wrench'></i> Create a new group</a> </li>";
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

            <form id ='groupForm' action='groups.php' method='post' accept-charset='UTF-8'>
            <div class="container-fluid">

                <div class="row">
                    <label for='groupName'>New Group Name</label>
                    <input type='text' name='groupName' id='groupName' />
                    <input type='submit' name='submit' id='submit'value='submit' />
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </form>
        </div>
        <!-- /#page-wrapper -->

    </div>
</body> 
</html>
