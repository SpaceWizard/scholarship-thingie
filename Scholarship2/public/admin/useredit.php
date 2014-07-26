<?php require_once("adminheader.php"); ?> 
<?php
if(isset($_POST)) {
	if(isset($_POST["delete"])) {
		if($_POST["class"] == "student") {
			$database->delete_stu($_POST["ufid"]);
		}
		$database->deleteuser($_POST["ufid"]);
		redirect("user.php");
	}else if(isset($_POST["update"])) {
		$database->deleteuser($_POST["ufid"]);
		$database->insertuser($_POST["ufid"],$_POST["class"],$_POST["password"]);
	}
}
//}
?>
<?php require_once("header.php"); ?>
<form action="useredit.php" method="POST">
	<input type="submit" name="logout" value="Logout">
</form>
<?php
$result = $database->get_users();
foreach($result as $set) {
	if($set["ufid"] == $_SESSION["user"]){
		$crass = $set["class"];
	}
}
echo "<form action='useredit.php' method=\"POST\">";
echo "username: ";
echo "<input type=\"text\" name='ufid' autocomplete=\"off\" value='".$_SESSION["user"]."' />";
echo "<br/>";
echo "class: ";
echo "<input type=\"text\" name='class' autocomplete=\"off\" value='".$crass."' />";
echo "<br/>";
$pass = $database->getpassword($_SESSION["user"]);
echo "password : ";
echo "<input type=\"text\" name='password' autocomplete=\"off\" value='".$pass."' />";
echo "<br/>";
echo "<input type=\"submit\" name=\"delete\" value=\"delete\">";
echo "<input type=\"submit\" name=\"update\" value=\"update\">";
echo "</form>";
?>
<a href="user.php">Return to User Edit Page</a>

<?php
$database->disconnect();
?>
</body>
</html>