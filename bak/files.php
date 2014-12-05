<?php
require_once('header.php');
	// Create DB connection
	$servername = "bur.ccg2fbosv7le.us-west-2.rds.amazonaws.com:3306";
	$username = "bmaple";
	$password = "security";

	$my_files = '';
    $displayName = '';
	$filename = '';
    $uploadDate = '';
	$fileID = '';
	$conn = new mysqli($servername, $username, $password, 'Bureaucrat');

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} else {
		if ($stmt = $conn->prepare("SELECT users.Username, file.Filename, file.UploadDate, file.FileID FROM file LEFT JOIN (users) ON (file.UploaderID = users.userID) WHERE file.UploaderID=1")) {  
			$stmt->execute();
			$stmt->bind_result($displayName, $filename, $uploadDate, $fileID);
			while($stmt->fetch()){
				//$stmt2 = $conn->prepare("SELECT Username FROM users WHERE UserID=1");

					$my_files .= "<ul><li>Author: " . $displayName . "</li>" .
								  "<li>File Name: " . $filename . "</li>" .
								  "<li>Upload Date: " . $uploadDate . "</li></ul>
								  <form method='post' action='details.php'><input type='hidden' name='fid' value='" . $fileID . "'><input type='submit' value='View File'></form>";
			}
		}
	}
?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="files.php"><i class="fa fa-fw fa-file"></i> Your Files</a>
                    </li>
                    <li>
                        <a href="upload.php"><i class="fa fa-fw fa-edit"></i> Upload Files</a>
                    </li>
                    <li>
                        <a href="manage.php"><i class="fa fa-fw fa-wrench"></i> Manage Files and Groups</a>
                    </li>
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
						<?php print $my_files ?>

                    </div>
                    <div class="col-lg-6">


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