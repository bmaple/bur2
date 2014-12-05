<?php
	function redirect_to ($location) {
	    if($location != NULL) {
	        header("Location: {$location}");
	        exit;
	    }
	}
	
	$target_path = "uploads/";

	$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
		echo "The file ".  basename($_FILES['uploadedfile']['name']) . " has been uploaded";
	} else{
		echo "There was an error uploading the file, please try again!";
	}
	
	// Create DB connection
	$servername = "bur.ccg2fbosv7le.us-west-2.rds.amazonaws.com:3306";
	$username = "bmaple";
	$password = "security";

	$conn = new mysqli($servername, $username, $password, 'Bureaucrat');

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} else {
		// If we didn't get a file id, upload a new file
		if(empty($_POST['file_id'])){
			if ($stmt = $conn->prepare("INSERT INTO file (Filename, Filepath, FileType, VersionNumber, UploaderID, UploadDate, ModifiedDate, ApprovalStatus, FileStatus, Description) VALUES (?,?,?,1,1,CURDATE(),CURDATE(),'Pending',1,?)")) {  
				$stmt->bind_param("ssss",basename( $_FILES['uploadedfile']['name']),$target_path,pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION),$_POST['file_comments']);
				$stmt->execute();
				if (!$conn->commit()) {
					$error .= "Couldn't commit!";
				}				
				$stmt->close();
			}
			
			/* //Find the file id
			$file_id = '';
			if ($stmt = $conn->prepare("SELECT max(FileID) FROM file")) {  
				$stmt->execute();
				$stmt->bind_result($file_id);
				$stmt->close();
				echo "Our file id is " .$file_id;
			}else{
				echo "error!";
			}
			$UserId = '';
			
			//Find all approvers for file
			if ($stmt2 = $conn->prepare("SELECT UserID FROM groupmembers WHERE GroupId = (SELECT GroupID FROM groupmembers WHERE UserID=1)")) {  
				$stmt2->execute();
				$stmt2->store_result();
				$stmt2->bind_result($UserId);
				while($stmt2->fetch()){
					//Add all approvers to the approvers table
					if ($stmt = $conn->prepare("INSERT INTO approvers (ApproverID, FileID, ApprovalStatus) VALUES (?,?,'Pending')")) {  
						$stmt->bind_param("ii", $UserId,$file_id);
						$stmt->execute();
						if (!$conn->commit()) {
							$error .= "Couldn't commit!";
						}				
						$stmt->close();
					}
				}
				$stmt2->close();
			} */
			
		} else {
/* 			$new_version = 1;
			if ($stmt2 = $conn->prepare("SELECT VersionNumber, Filename, UploaderID, UploadDate FROM file WHERE FileID=?")) {  
				$stmt2->bind_param("i",$_POST['file_id']);
				$stmt2->execute();
				$stmt2->store_result();
				$stmt2->bind_result($version, $filename, $uploaderID, $uploadDate);
				$stmt2->fetch();
				$stmt2->close();
			}
			$new_version = (intval($version) + 1);
			if ($stmt = $conn->prepare("INSERT INTO file (Filename, Filepath, FileType, VersionNumber, UploaderID, UploadDate, ModifiedDate, ApprovalStatus, FileStatus) VALUES (?,?,?,?,?,?,CURDATE(),'Pending',1)")) {  
				$stmt->bind_param("ssssi",$filename,$target_path,pathinfo($_FILES['uploadedfile']['name'], PATHINFO_EXTENSION), $new_version);
				$stmt->execute();
				if (!$conn->commit()) {
					$error .= "Couldn't commit!";
				//} 
				//$stmt->close();
			//} */
		}
	}
	
	echo $conn->error;
?> 