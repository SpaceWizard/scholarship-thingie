<?php require_once("trollheader.php"); ?> 
<?php
//$database->deletrow("mami","users","ufid");
$row_num = $database->row_num("users");
$colums = array("key"=>"ufid","password","class");
$colum_num = count($colums);
?>
<?php require_once("header.php"); ?>
<form action="user.php" method="POST">
	<input type="submit" name="logout" value="big blue button">
</form>
<form action="useredit.php" method="POST">
<?php 

display4edit($colums,"users","ufid",$row_num,$colum_num);
/*$yaranaika = $database->geteverything($colums,"users","ufid");
for($i=0;$i<$row_num;$i++) {
	for($j=0;$j<$colum_num;$j++) {
		echo $yaranaika[$j][$i];
		echo "|";
	}
	echo "<input type=\"submit\" name=".$yaranaika[0][$i]." value=\"delet\">";
	echo "<br/>";
}*/
?>
</form>
<a href="mane.php">return to mane page</a>
</body>
</html>