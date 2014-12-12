<?php
require_once('header.php');
require_once('check.php');
    $userID = $user->getId();
	
	// Create DB connection
	$servername = "bur.ccg2fbosv7le.us-west-2.rds.amazonaws.com:3306";
	$username = "bmaple";
	$password = "security";

	$my_files = '';
    $manage_files = '';
    $displayName = '';
	$filename = '';
    $uploadDate = '';
	$fileID = '';
	$filePath = '';
	$approvedFileID = '';
    $approvalStatus = '';
    $approvalId = '';
    $selectedStatus = '';
    $currentFile = '';
    $fileHistory = '';
    $currentName = '';
    $versionNumber = '';
    $modifiedDate = '';
	$conn = new mysqli($servername, $username, $password, 'Bureaucrat');

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

    else {
        if(isset($_POST['history'])) {
            $currentName = $_POST['history'];
        }
        if(isset($_POST['hiddenID'])) {
            $fileID = $_POST['hiddenID'];
        }
        


        //Grab Current Version
        if($stmt = $conn->prepare("SELECT users.Username, file.Filename, file.UploadDate, file.VersionNumber, file.ModifiedDate, file.FileID, file.Filepath, file.ApprovalStatus FROM file LEFT JOIN (users) ON (file.UploaderID = users.userID) WHERE file.UploaderID= ?  AND file.Filename = ? AND file.FileStatus = 1")) {
            $stmt->bind_param("is",$userID,$currentName);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($displayName, $filename, $uploadDate, $versionNumber, $modifiedDate, $fileID, $filePath, $approvalStatus);

            while($stmt->fetch()) {
                $currentFile .= "<table class='table table-hover table-striped'>
                                    <tr>
                                        <td>File Name: </td>
                                        <td><a download href=" . $filePath . ">" . $filename . "</a></td>
                                    </tr>
                                    <tr>
                                        <td>Author: </td>
                                        <td>" . $displayName . "</td>
                                    </tr>
                                    <tr>
                                        <td>Version: </td>
                                        <td>" . $versionNumber . "</td>
                                    </tr>
                                    <tr>
                                        <td>Upload Date: </td>
                                        <td>" . $uploadDate . "</td>
                                    </tr>
                                    <tr>
                                        <td>Modified Date: </td>
                                        <td>" . $modifiedDate . "</td>
                                    </tr>
                                    <tr>
                                        <td>Approval Status:  </td>
                                        <td>" . $approvalStatus . "</td>
                                    </tr>
                                    </table>";
            }
        }

        if($stmt = $conn->prepare("SELECT users.Username, file.Filename, file.UploadDate, file.VersionNumber, file.ModifiedDate, file.FileID, file.Filepath, file.ApprovalStatus FROM file LEFT JOIN (users) ON (file.UploaderID = users.userID) WHERE file.UploaderID= ?  AND file.Filename = ? AND file.FileStatus = 0")) {
            $stmt->bind_param("is",$userID,$currentName);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($displayName, $filename, $uploadDate, $versionNumber, $modifiedDate, $fileID, $filePath, $approvalStatus);

            while($stmt->fetch()) {
                $currentFile .= "<table class='table table-hover table-striped'>
                                    <tr>
                                        <td>File Name: </td>
                                        <td><a download href=" . $filePath . ">" . $filename . "</a></td>
                                    </tr>
                                    <tr>
                                        <td>Author: </td>
                                        <td>" . $displayName . "</td>
                                    </tr>
                                    <tr>
                                        <td>Version: </td>
                                        <td>" . $versionNumber . "</td>
                                    </tr>
                                    <tr>
                                        <td>Upload Date: </td>
                                        <td>" . $uploadDate . "</td>
                                    </tr>
                                    <tr>
                                        <td>Modified Date: </td>
                                        <td>" . $modifiedDate . "</td>
                                    </tr>
                                    <tr>
                                        <td>Approval Status:  </td>
                                        <td>" . $approvalStatus . "</td>
                                    </tr>
                                    </table>";
            }
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
                        echo "<li> <a href='groups.php'><i class='fa fa-fw fa-plus'></i> Create a New Group</a> </li>";
                    }
                    ?>
                    <li>
                        <a href="managefiles.php"><i class="fa fa-fw fa-edit"></i> Manage Files</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-6">
						<?php print $currentFile ?>

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
