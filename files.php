<?php
require_once('header.php');
//require_once('check.php');

	$user = isLoggedIn();
    $userID = $user->getId();
	
	// Create DB connection
	$servername = "bur.ccg2fbosv7le.us-west-2.rds.amazonaws.com:3306";
	$username = "bmaple";
	$password = "security";

	$my_files = '';
    $displayName = '';
	$filename = '';
    $uploadDate = '';
	$fileID = '';
	$filePath = '';
	$approvedFileID = '';
	$conn = new mysqli($servername, $username, $password, 'Bureaucrat');

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} else {
		if ($stmt = $conn->prepare("SELECT users.Username, file.Filename, file.UploadDate, file.FileID, file.Filepath FROM file LEFT JOIN (users) ON (file.UploaderID = users.userID) WHERE file.UploaderID='$userID'")) {  
			$stmt->execute();
			$stmt->bind_result($displayName, $filename, $uploadDate, $fileID, $filePath);
			while($stmt->fetch()){
				$stmt2 = $conn->prepare("SELECT username FROM user WHERE UserID='$userID'");
                if($stmt3 = $conn->prepare("SELECT FileID from approvers WHERE FileID = '$fileID'")) {
                   $stmt3->execute();
                   $stmt3->bind_result($approveFileID);
                }

                            $my_files .= "    <table class='table table-hover table-striped'>
                                                            <tr>
                                                                <td>File Name: </td>
                                                                <td><a download href=" . $filePath . ">" . $filename . "</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Author: </td>
                                                                <td>" . $displayName . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Upload Date: </td>
                                                                <td>" . $uploadDate . "</td>
                                                            </tr>";
                    if($fileID == $approvedFileID) {
                        $my_files .= "<form><select name='choice'>
                                             <option value='' selected='selected'></option>
                                             <option value='Approve'>Approve</option>
                                             <option value='Reject'>Reject</option>
                                             </select>
                                             <input type='submit' value='Submit'></form>";
                    }

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
                    
                    <?php
                    if($user->isAdmin()) {
                        echo "<li> <a href='manage.php'><i class='fa fa-fw fa-wrench'></i> Manage Groups and Users</a> </li>";
                        echo "<li> <a href='groups.php'><i class='fa fa-fw fa-wrench'></i> Create a New Group</a> </li>";
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
                    <div class="col-lg-3">
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
