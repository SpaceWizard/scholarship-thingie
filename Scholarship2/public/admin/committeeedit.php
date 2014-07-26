<?php require_once("adminheader.php"); ?> 
<?php
$colums = array("key"=>"ufid","name");
editheader($colums,"committee","committee.php")
?>
<?php require_once("header.php"); ?>
<form action="committeeedit.php" method="POST">
	<input type="submit" name="logout" value="big blue button">
</form>
<?php
REALdisplay4edit($colums,$silverkey,"committee","committeeedit.php");
?>

<a href="committee.php">return to commfag page</a>
<?php
$database->disconnect();
?>
</body>
</html>