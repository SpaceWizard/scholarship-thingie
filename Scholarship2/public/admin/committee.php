<?php require_once("adminheader.php"); ?> 
<?php
$row_num = $database->row_num("committee");
$colums = array("key"=>"ufid","name");
$colum_num = count($colums);
?>
<?php require_once("header.php"); ?>
<form action="committee.php" method="POST">
	<input type="submit" name="logout" value="big blue button">
</form>
<form action="committeeedit.php" method="POST">
<?php 
display4edit($colums,"committee","ufid");
?>
</form>
<a href="mane.php">return to mane page</a>
<?php
$database->disconnect();
?>
</body>
</html>