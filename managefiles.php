<?php
require_once('header.php');

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
	$modifiedDate = '';
    $approvalStatus = '';
    $approvalId = '';
    $selectedStatus = '';
    $fileVersion = '';
    $totalApproval = true;
	$conn = new mysqli($servername, $username, $password, 'Bureaucrat');

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

    else {
        //FILE APPROVAL AND REJECTION
        //Update a file's status if a user elects to review a file
        if(isset($_POST['submitReview'])) {
            $reviewID = $_POST['submitReview'];
            $verdict = $_POST['verdict'];
            $userComment = $_POST['userComment'];

            //File Rejected
            if($verdict == 'Rejected') {

                //Change user's ApprovalStatus to rejected in approvers table
               if($rejection = $conn->prepare("UPDATE approvers SET ApprovalStatus='Rejected' WHERE ApproverID = ? AND FileID = ?")) {
                $rejection->bind_param("ii",$userID,$reviewID);
                $rejection->execute();
               }

                //Insert user's comment into comment table if there is one
                if($comment = $conn->prepare("INSERT INTO comment (CommentID,FileID,CommenterID,Comment,ApprovalStatus) VALUES (NULL,?,?,?,'Rejected')")) {
                    if($userComment == '') {
                        $userComment = "No Comment Given.";
                    }
                    $comment->bind_param("iis",$reviewID,$userID,$userComment);
                    $comment->execute();
                }

                //Update the file's status to Rejected in the file table
                if($rejectFile = $conn->prepare("UPDATE file SET ApprovalStatus='Rejected' WHERE FileID = ?")) {
                    $rejectFile->bind_param("i",$reviewID);
                    $rejectFile->execute();
                }
            }

            //File Approved
            else {
                //Change user's ApprovalStatus to approved in approvers table
                if($approval = $conn->prepare("UPDATE approvers SET ApprovalStatus='Approved' WHERE ApproverID = ? AND FileID = ?")) {
                    $approval->bind_param("ii",$userID,$reviewID);
                    $approval->execute();
                }

                //Insert user's comment into comment table if there is one
                if($comment = $conn->prepare("INSERT INTO comment (CommentID,FileID,CommenterID,Comment,ApprovalStatus) VALUES (NULL,?,?,?,'Approved')")) {
                    if($userComment == '') {
                        $userComment = "No Comment Given.";
                    }
                    $comment->bind_param("iis",$reviewID,$userID,$userComment);
                    $comment->execute();
                }

                //Check to see if this is last approval required for full approval
                if($approvalCheck = $conn->prepare("SELECT ApprovalStatus FROM approvers WHERE FileID = ?")) {
                    $approvalCheck->bind_param("i",$reviewID);
                    $approvalCheck->execute();
                    $approvalCheck->store_result();
                    $approvalCheck->bind_result($approvalStatus);

                    while($approvalCheck->fetch()) {
                        if($approvalStatus != 'Approved') {
                            $totalApproval = false;
                        }
                    }
                    if($totalApproval == true) {
                        if($fileApproved = $conn->prepare("UPDATE file SET ApprovalStatus = 'Approved' WHERE FileID = ?")) {
                            $fileApproved->bind_param("i",$reviewID);
                            $fileApproved->execute();
                        }
                    }
                }
            }
        }

        //Gather files user must approve
        if($stmt4 = $conn->prepare("SELECT FileID, ApprovalStatus FROM approvers WHERE ApproverID = ?")) {
            $stmt4->bind_param("i",$userID);
            $stmt4->execute();
            $stmt4->store_result();
            $stmt4->bind_result($approveFileID, $selectedStatus);
            while($stmt4->fetch()) {
                if($stmt5 = $conn->prepare("SELECT users.Username, file.Filename, file.UploadDate, file.ModifiedDate, file.VersionNumber, file.FileID, file.Filepath, file.ApprovalStatus FROM file LEFT JOIN (users) ON (file.UploaderID = users.userID) WHERE file.FileID = ? AND file.FileStatus = 1")) {
                    $stmt5->bind_param("i",$approveFileID);
                    $stmt5->execute();
                    $stmt5->store_result();
                    $stmt5->bind_result($displayName, $filename, $uploadDate, $modifiedDate, $versionNumber, $fileID, $filePath, $approvalStatus);

                    while($stmt5->fetch()) {
                        $manage_files .= "<table class='table table-hover table-striped'>
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
                                        <td>ModifiedDate: </td>
                                        <td>" . $modifiedDate . "</td>
                                    </tr>
                                    <tr>
                                        <td>Approval Status:  </td>
                                        <td>" . $approvalStatus . "</td>
                                    </tr>
                                    </table>";

                        //See if the user needs to approve or reject a given file
                        if($selectedStatus == 'Pending') {
                            $manage_files .= "<form action='managefiles.php' method='post'>
                                              <select name='verdict'>
                                                <option selected value='Approved'>Approve</option>
                                                <option value='Rejected'>Reject</option>
                                              </select>
                                              <button type='submit' name='submitReview' value='" . $fileID . "'>Submit Review</button><br>
                                              <textarea name='userComment' maxlength='255' rows='2' cols='25'></textarea>
                                              </form>";
                        }
                        //$manage_files .= "</div>";
                    }
                }
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
                    <li class='active'>
                        <a href="managefiles.php"><i class="fa fa-fw fa-edit"></i> Manage Files</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-3">
                        

                    </div>
                    <div class="col-lg-6">
                        <h1 style="text-align:center;">Manage Files</h1>
						<?php print $manage_files ?>

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
