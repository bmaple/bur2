<?php
require_once('header.php');

$update_query = "UPDATE users SET Username='$username' WHERE StudentID='$sID'";
if ( !($result = mysqli_query( $database, $update_query ) ) )
{
    print( "<p>Could not execute query!</p>" );
    die( mysqli_error($database) );
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

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-6">

                        <form role="form">

                            <div class="form-group">
                                <label>Update Username</label>
                                <input class="form-control" maxlength='64'>
                            </div>
                            
                            <div class="form-group">
                                <label>Update Password</label>
                                <input class="form-control" maxlength='64'>
                            </div>

                            <button type="submit" class="btn btn-default">Apply Changes</button>

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