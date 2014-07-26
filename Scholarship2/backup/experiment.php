<?php
require_once("../includes/init.php");
$values = array("123","456");
$table = "committee";
$colums = array("ufid","name");
$database->insertrow($values,$table,$colums);
?>