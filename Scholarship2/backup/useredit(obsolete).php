<?php require_once("trollheader.php"); ?> 
<?php
$colums = array("key"=>"ufid","password","class");
editheader($colums,"users","user.php")
/*if(isset($_POST)) {
	if(isset($_POST["delete"])) {
		$key = $colums["key"];
		$database->deletrow($_POST[$key],"users",$key);
		redirect("user.php");
	}
	else if(isset($_POST["update"])) {
		$key = $colums["key"];
		foreach($colums as $colum) {
			$value = $_POST[$colum];
			$database->updatecolum($_POST[$key],$value,"users",$colum,$key);
		}
		$silverkey = $_POST[$key];
	}
	else {
		$silverkey = NULL;
		foreach($_POST as $faggot => $noonecares){
			$silverkey = $faggot;
		}
		if(!$silverkey) {
			redirect("user.php");
		}
	}
}
else {
	redirect("user.php");
}*/
?>
<?php require_once("header.php"); ?>
<form action="useredit.php" method="POST">
	<input type="submit" name="logout" value="big blue button">
</form>
<?php
REALdisplay4edit($colums,$silverkey);
?>
<!-- <form action="useredit.php" method="POST">
<?php 
//$colums = array("key"=>"ufid","password","class");
/*foreach($colums as $colum) {
	echo $colum.": ";
	echo "<input type=\"text\" name=".$colum." autocomplete=\"off\" value='".$database->getelementfromrow($colum,$silverkey,"users",$colums["key"])."' />";
	echo "<br/>";
}*/
?>
<input type="submit" name="delete" value="delete">
<input type="submit" name="update" value="update">
</form> -->
<a href="user.php">return to wuuuuzer page</a>
</body>
</html>