<html>
<?php
require_once('check.php');
$user = isLoggedIn();

	//Database Information
$dbUser = 'bmaple';
$pass = 'security';
$db = 'Bureaucrat';
$conn = new mysqli('bur.ccgfbosv7le.us-west-2.rds.amazonaws.com:3306', $dbUser, $pass, $db) or die("Could not connect to Registration database");

	//echo $user->username;

	//Fetch current User's ID
	$idQuery = "SELECT UserID FROM users WHERE username = '$user->username'";
	$idResult = mysqli_query($conn,$idQuery);
	$idRow = mysqli_fetch_assoc($idResult);
	$userID = $idRow['UserID'];
	//echo $userID;
?>
<head>
	<title>Approval</title>
</head>
<body>
<h1>Your Files</h1>
	<!--Files the user manage-->
	<div class='manage'>
		<?php
		$manageQuery = "SELECT * FROM approvers, file, users WHERE approvers.ApproverID = '$userID' AND approvers.FileID = file.FileID AND file.UploaderID = users.UserID ";
		$manageResult = mysqli_query($conn, $manageQuery);

		echo "<h2>Files You Manage</h2>
		<table>";

		while($manageRow = mysqli_fetch_assoc($manageResult)) {
			echo "<tr><td><ul>";
			echo "<li>File Author: " . $manageRow['Username'] . "</li>";
			echo "<li>File Name: " . $manageRow['Filename'] . "</li>";
			echo "<li>Upload Date: " . $manageRow['UploadDate'] . "</li>";
			echo "<form method='post' action='details.php'><input type='hidden' name='fid' value='" . $manageRow['FileID'] . "'><input type='submit' value='View File'></form>";
			echo "</ul></td></tr>";
		}
		echo "</table>"

		?>
	</div>

	<!--Files beloning to the user-->
	<div class='owner'>
		<?php
		$ownerQuery = "SELECT * FROM users, file WHERE users.userID = '$userID' AND users.UserID = file.UploaderID";
		$ownerResult = mysqli_query($conn, $ownerQuery);

		echo "<h2>Files You Own</h2>
		<table>";

		while($ownerRow = mysqli_fetch_assoc($ownerResult)) {
			echo "<tr><td><ul>";
			echo "<li>File Name: " . $ownerRow['Filename'] . "</li>";
			echo "<li>Upload Date: " . $ownerRow['UploadDate'] . "</li>";
			echo "<li>Approval Status: " . $ownerRow['ApprovalStatus'] . "</li>";
			echo "<form method='post' action='details.php'><input type='hidden' name='fid' value='" . $ownerRow['FileID'] . "'><input type='submit' value='View File'></form>";
			echo "</li></td></tr>";
		}
		echo "</table>";
		?>
	</div>
</body>
</html>