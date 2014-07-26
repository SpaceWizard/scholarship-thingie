<?php require_once("../../includes/init.php"); ?>
<?php 
$message =  "Welcome ". $_SESSION["ufid"].".";
if(!$session->checklogin("student")){
	redirect("../login.php");
}

else {

}
if(isset($_POST["logout"])){
	$session->logout();
	redirect("../login.php");
}
?>
