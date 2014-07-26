<?php require_once("../includes/init.php"); ?>
<?php
$committee = $_SESSION["committee"];
if(isset($_POST)) {
//	die("push");
	foreach($_POST as $faggot => $noonecares) {
		$stu = $faggot;
	}
	if(isset($stu)) {
		$columns = array("committee","student");
		$values = array($committee,$stu);
		$database->insertrow($values,"com_stu",$columns);
	}
}
?>
<?php

$colums = array("key" => "ufid","name");
//$yaranaika = $database->geteverything($colums,"students","ufid");
echo "<form action=\"exp-c-s.php\" method=\"POST\">";
display4edit($colums,"students","ufid",2,2);
echo "</form>";
?>