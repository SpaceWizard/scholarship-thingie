<?php require_once("adminheader.php"); ?>
<?php require_once("header.php"); ?>
<form action="mane.php" method="POST">
<p>
	<input type="submit" name="logout" value="Logout">
</p>
</form>
<p>
<a href="user.php">Edit Users</a><br>
<a href="scholarship.php">Edit Scholarships</a><br>
<a href="AssignStudentComm.php">Assign a Student to a Committee</a><br>
<a href="OptimalAward.php">Get Scholarship Awarding</a><br>
 <a href="Solve.php">Manually Assign Scholarships</a><br> 
</p>
<?php
$database->disconnect();
?>
</body>
</html>