<?php require_once("adminheader.php"); ?> 
<?php

$colums = array("key"=>"title","quantity","award");
if(isset($_POST["requirement"])) {
	redirect("scholarship_requirements.php");
}
if(isset($_POST["preference"])) {
	redirect("scholarship_preferences.php");
}

if(isset($_POST["submit"])) {
	if($_POST["submit"] == "Update"){
		$oldName = str_replace("_"," ",$_SESSION["scholarship"]);
		$oldamount = $_SESSION["award"];
		$_SESSION["scholarship"]=$_POST["name"];
		$_SESSION["award"]=$_POST["amount"];
		$database->update_scholarship($oldName,$_POST["quantity"],$oldamount,$_POST["deadline"],$_POST["name"], $_POST["amount"]);
		redirect("scholarshipedit.php");
	}
	else if($_POST["submit"] == "Delete"){
		$database->delete_scholarship(str_replace("_"," ",$_SESSION["scholarship"]),$_SESSION["award"]);
		redirect("scholarship.php");
	}
}
?>
<?php require_once("header.php"); ?>
<form action="scholarshipedit.php" method="POST">
	<input type="submit" name="logout" value="Logout">
</form>
<form action="scholarshipedit.php" method="POST">
<?php
$result = $database->get_scholarship(str_replace("_"," ",$_SESSION["scholarship"]));
echo "<label for=\"name\" >Scholarship Name: ".str_replace("_"," ",$_SESSION["scholarship"])."&nbsp;</label>";
echo "<input type=\"hidden\" name='name' id='name' autocomplete=\"off\" value='".str_replace("_"," ",$_SESSION["scholarship"])."' />";
echo "<br/>";
echo "<label for=\"quantity\" >Quantity: &nbsp;</label>";
echo "<input type=\"text\" name='quantity' id='quantity' autocomplete=\"off\" value='".$result["quantity"]."' />";
echo "<br/>";
//echo "<label for=\"amount\" >Award Amount: &nbsp;</label>";
echo "<input type=\"hidden\" name='amount' id='amount' autocomplete=\"off\" value='".$_SESSION["award"]."' />";
echo "<label for=\"deadline\" >Deadline: &nbsp;</label>";
echo "<input type='date' name='deadline' id='deadline' autocomplete=\"off\" value='".$result["deadline"]."' />";
echo "<br/>";
echo "<input type=\"submit\" name=\"submit\" value=\"Delete\">";
echo "<input type=\"submit\" name=\"submit\" value=\"Update\">";
?>
</form>
<br><form action="scholarshipedit.php" method="POST">
	<input type="submit" name="requirement" value="Edit Scholarship Requirements">
</form>
<form action="scholarshipedit.php" method="POST">
	<input type="submit" name="preference" value="Edit Scholarship Preferences">
</form>
<a href="scholarship.php">Return to Scholarship Page</a>
<?php
$database->disconnect();
?>
</body>
</html>