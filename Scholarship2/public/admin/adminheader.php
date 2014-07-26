<?php require_once("../../includes/init.php"); ?>
<?php 
$message = "Welcome back ". $_SESSION["ufid"].".";
if(!$session->checklogin("admin")){
	redirect("../login.php");
}

if(isset($_POST["logout"])){
	$session->logout();
	redirect("../login.php");
}
?>
