<?php require_once("../../includes/init.php"); ?>
<?php 
$message = "Welcome back, ".$_SESSION["ufid"];
if(!$session->checklogin("committee")){
	redirect("../login.php");
}

else {

}
if(isset($_POST["logout"])){
	$session->logout();
	redirect("../login.php");
}
?>
