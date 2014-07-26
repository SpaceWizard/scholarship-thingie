<?php require_once("stuheader.php"); ?>
<?php require_once("header.php"); ?>
<form action="mane.php" method="POST">
	<input type="submit" name="logout" value="Logout">
</form>
<?php
$appDone = $database->app_done($_SESSION["ufid"]);
$appStart = $database->app_start($_SESSION["ufid"]);

if($appDone[0]==1){
	 echo "You have completed the application process!";
}elseif($appStart[0]==1){
	echo "<a href=\"studentApp.php\">Continue Started Application</a> ";

}else{
	echo "<a href=\"studentApp.php\">Start an Application</a> ";
}


?>

<!-- <a href="app1.php">fill out teh application form</a> -->
<!-- <a href="app2.php">fill out teh application form(continued)</a> -->
<!-- <a href="app3.php">display eligible scholarships</a> -->
<?php
$database->disconnect();
?>
</body>
</html>