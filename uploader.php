<?php
	require_once('check.php');

	$user = isLoggedIn();
    $userID = $user->getId();
	function redirect_to ($location) {
	    if($location != NULL) {
	        header("Location: {$location}");
	        exit;
	    }
	}
	
	$target_path = "uploads/";
	
	// Create DB connection
	$servername = "bur.ccg2fbosv7le.us-west-2.rds.amazonaws.com:3306";
	$username = "bmaple";
	$password = "security";

	$conn = new mysqli($servername, $username, $password, 'Bureaucrat');
	//We don't want autocommit on incase there is a problem with file uploading
	$conn->autocommit(TRUE);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} else {
		// If we didn't get a file id, upload a new file
		if(empty($_POST['file_id'])){
			$version = 1;
			$filename = '';
			
			//See if anyone else has submitted a file with same name
			if ($stmt2 = $conn->prepare("SELECT Filename FROM file WHERE Filename=?")) {  
				$stmt2->bind_param("s",basename( $_FILES['uploadedfile']['name']));
				$stmt2->execute();
				$stmt2->store_result();
				$stmt2->bind_result($filename);
				$stmt2->fetch();
				$stmt2->close();
			}
			
			if ($filename == basename( $_FILES['uploadedfile']['name'])) {
				echo "Please change your file name! File already exists!";
				exit(1);
			}
			
			#This is for version control
			$target_path = $target_path . $version . "_" . basename( $_FILES['uploadedfile']['name']); 
			preg_replace('/\s+/', '_', $target_path);
			
			if ($stmt = $conn->prepare("INSERT INTO file (Filename, Filepath, FileType, VersionNumber, UploaderID, UploadDate, ModifiedDate, ApprovalStatus, FileStatus, Description) VALUES (?,?,?,?,?,CURDATE(),CURDATE(),'Not Submitted',1,?)")) {  
				$stmt->bind_param("sssiis",basename($_FILES['uploadedfile']['name']),$target_path,pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION),$version,$userID,$_POST['file_comments']);
				$stmt->execute();
				$stmt->close();
			}
			
			#The file is copied to our upload folder
			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
				if (!$conn->commit()) {
					echo "Couldn't commit!";
				} else {
					echo "The file ".  basename($_FILES['uploadedfile']['name']) . " has been uploaded";
				}
			} else{
				$conn->rollback();
				echo "There was an error uploading the file, please try again!";
				exit(1);
			}
		} else {
 			$new_version = 1;
			
			//Get the old file data
			if ($stmt2 = $conn->prepare("SELECT VersionNumber, Filename, UploaderID, UploadDate, ApprovalStatus, FileType, FileStatus FROM file WHERE FileID=?")) {  
				$stmt2->bind_param("i",$_POST['file_id']);
				$stmt2->execute();
				$stmt2->store_result();
				$stmt2->bind_result($version, $filename, $uploaderID, $uploadDate, $approval_status, $ext, $file_status);
				$stmt2->fetch();
				$stmt2->close();
			}
			
			#This is for version control, make sure we can't upload in certain cases
			if ($userID != $uploaderID){
				echo "You can't update someone else's file!";
				exit(1);
			}
			
			if (!$approval_status == 'Approved') {
				echo "You can't update a released file!";
				exit(1);
			}
			
			if (pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION) != $ext){
				echo "You must upload a file of type " . $ext;
				exit(1);
			}			
			
			if ($file_status != 1){
				echo "Only the latest file can be updated!";
				exit(1);
			}	
			
			$new_version += intval($version);
			
			$target_path = $target_path . $new_version . "_" . $filename; 
			
			if ($stmt = $conn->prepare("INSERT INTO file (Filename, Filepath, FileType, VersionNumber, UploaderID, UploadDate, ModifiedDate, ApprovalStatus, FileStatus, Description) VALUES (?,?,?,?,?,?,CURDATE(),'Not Submitted',1,?)")) {  
				$stmt->bind_param("ssssiss",$filename,$target_path,pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION),$new_version,$userID,$uploadDate,$_POST['file_comments']);
				$stmt->execute();
				$stmt->close();
			}
			
			#We use FileStatus to track the most current file, the previous file is no longer current
			if ($stmt = $conn->prepare("UPDATE file SET FileStatus = 0 WHERE FileID=?")) {  
				$stmt->bind_param("i",$_POST['file_id']);
				$stmt->execute();
				$stmt->close();
			}
			
			#The file is copied to our upload folder
			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
				if (!$conn->commit()) {
					echo "Couldn't commit!";
					exit(1);
				} else {
					echo "The file ".  basename($_FILES['uploadedfile']['name']) . " has been uploaded";
				}
			} else{
				$conn->rollback();
				echo "There was an error uploading the file, please try again!";
				exit(1);
			}
		}
	}
	
	echo $conn->error;
	redirect_to("files.php");
?> 
