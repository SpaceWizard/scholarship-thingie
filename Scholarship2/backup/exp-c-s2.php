<?php require_once("../includes/init.php"); ?>
<?php
if(isset($_POST)) {
//	die("push");
	foreach($_POST as $faggot => $noonecares) {
		$com = $faggot;
	}
	if(isset($com)) {
		$_SESSION["committee"] = $com;
		redirect("exp-c-s.php");
	}
}
?>
<?php

$colums = array("key" => "ufid","name");
//$yaranaika = $database->geteverything($colums,"students","ufid");
echo "<form action=\"exp-c-s2.php\" method=\"POST\">";
display4edit($colums,"committee","ufid",2,2);
echo "</form>";
?>