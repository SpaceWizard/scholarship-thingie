<?php require_once("trollheader.php"); ?> 
<?php
$colums = array("key"=>"ufid","password","class");
editheader($colums,"users","user.php")
?>
<?php require_once("header.php"); ?>
<form action="useredit.php" method="POST">
	<input type="submit" name="logout" value="big blue button">
</form>
<?php
REALdisplay4edit($colums,$silverkey);
?>

<a href="user.php">return to wuuuuzer page</a>
</body>
</html>