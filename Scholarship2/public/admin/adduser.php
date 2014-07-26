<?php require_once("adminheader.php"); ?> 
<?php require_once("header.php"); 

if(isset($_POST["add"])) {
	if($_POST["class"] == "student") {
	$database->create_stu($_POST["username"]);
	}
	$database->insertuser($_POST["username"],$_POST["class"],$_POST["password"]);
	$_SESSION["user"] = $_POST["username"];
	redirect("useredit.php");
}



?>


<form action="adduser.php" method="POST"><p>
	<label for="username" >Username: &nbsp;</label><input type="text" name="username" id="username"/><br><br>
	<label for="password" >Password: &nbsp;</label><input type="text" name="password" id="password"/><br><br>
	<label for="class" >Class: &nbsp;</label><input type="text" name="class" id="class"/><br><br>
	<input type="submit" name="add" value="Add User"/><br>
	<a href="user.php">Return to User Edit Page</a>
</p></form>
<?php

?>
</body>
</html>