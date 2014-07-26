<?php require_once("../includes/init.php"); ?>
<?php

$colums = array("title","score","comment");
if (isset($_POST["submit1"])) {
	unset($_POST["submit1"]);
	foreach($_POST as $key => $value) {
		//echo $key."=>".$value;
		
	}
}
?>
<?php
$result = array();
$pk = array("title","score");
$result = $database->geteverything($colums,"com_score",$pk);
display4score($result,"exp-c-score.php");
//$database->list4select("com_stu","committee","student","sa","students","ufid");
?>