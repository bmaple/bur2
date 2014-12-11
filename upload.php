<?php
require_once('header.php');

if(isset($_GET['file_id'])) {
	$file_id = $_GET['file_id'];
}else{
	$file_id = '';
}

?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="files.php"><i class="fa fa-fw fa-file"></i> Your Files</a>
                    </li>
                    <li class="active">
                        <a href="upload.php"><i class="fa fa-fw fa-edit"></i> Upload Files</a>
                    </li>
                    <!--<li>
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

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-6">

                        <form enctype="multipart/form-data" role="form" method="POST" action="uploader.php">

                            <div class="form-group">
                                <label>File input</label>
                                <input type="file" name="uploadedfile">
								<input type="hidden" name="file_id" value="<?php print $file_id ?>">
                            </div>

                            <div class="form-group">
                                <label>Comments</label>
                                <textarea name='file_comments' class="form-control" maxlength='255' rows="3"></textarea>
                            </div>
                            

                            <input type="submit" class="btn btn-default" />

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