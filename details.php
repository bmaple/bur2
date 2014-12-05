<html>
<head>
	<title>File Details</title>
</head>
<body>
	<?php
	require_once('check.php');
	$user = isLoggedIn();

	
	//Database Information
	$servername = "bur.ccg2fbosv7le.us-west-2.rds.amazonaws.com:3306";
	$username = "bmaple";
	$password = "security";
	$conn = new mysqli($servername, $username, $password, 'Bureaucrat');

	$idQuery = "SELECT UserID FROM users WHERE username = '$user->username'";
	$idResult = mysqli_query($conn,$idQuery);
	$idRow = mysqli_fetch_assoc($idResult);

	$userID = $idRow['UserID'];
	$fileID = $_POST['fid'];

	$fileQuery = "SELECT * FROM file, users WHERE file.FileID = '$fileID' AND file.UploaderID = users.UserID";
	$fileResult = mysqli_query($conn,$fileQuery);
	$fileRow = mysqli_fetch_assoc($fileResult);
	?>

	<!--PAGE CONTENT-->
	<div class='content'>

		<!--FILE DETAILS-->
		<div class='fileDetails'>
			<?php 
			print "<ul><li>File Name: " . $fileRow['Filename'] . "</li>";
			print "<li>File Author: " . $fileRow['Username'] . "</li>";
			print "<li>Approval Status: " . $fileRow['ApprovalStatus'] . "</li>";
			print "<li>File Version: " . $fileRow['VersionNumber'] . "</li>";
			print "<li>Upload Date: " . $fileRow['UploadDate']. "</li>";
			print "<li>Modified Date: " . $fileRow['ModifiedDate'] . "</li>";
			print "</ul>";
			?>
		</div>

		<!--FILE COMMENTS-->
		<div class='comments'>
			<?php
			$commentQuery = "SELECT * FROM comment, users WHERE comment.FileID='$fileID' AND comment.CommenterID = users.UserID";
			$commentResult = mysqli_query($conn,$commentQuery);
			$commentCount = mysqli_num_rows($commentResult);


			if($commentCount == 0) {
				print "No Comments";
			}
			else{
				print "<table border='5'><tr>
				<th>Commenter Username</th>
				<th>Comment</th></tr>";

				while($commentRow = mysqli_fetch_assoc($commentResult)) {
					print "<tr><td>" . $commentRow['Username'] . "</td>";
					print "<td>" . $commentRow['Comment'] . "</td></tr>";
				}
				print "</table>";
			}
			?>
		</div>
	</div>
	<br><br>
	<a href="files.php">Your Files</a>
</body>
</html>
