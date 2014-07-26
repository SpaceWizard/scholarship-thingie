<?php require_once("stuheader.php"); ?>
<?php require_once("header.php"); 

if(isset($_POST)) {
	foreach($_POST as $key => $value ) {
		if($_POST[$key]!="Save and Continue" && $_POST[$key]!="Submit Completed Application"){
			$database->addStudentRequ($_SESSION["ufid"],$_POST[$key]);
		}
	}
}
if(isset($_POST["submit"])){
	$database->deleteAllStudReq($_SESSION["ufid"]);
	foreach($_POST as $key => $value ) {
		if($_POST[$key]!="Save and Continue" && $_POST[$key]!="Submit Completed Application"){
			$database->addStudentRequ($_SESSION["ufid"],$_POST[$key]);	
		}
	}
	$database->completeApp($_SESSION["ufid"]);
	redirect("mane.php");
}
if(isset($_POST["save"])){
	$database->deleteAllStudReq($_SESSION["ufid"]);
	foreach($_POST as $key => $value ) {
		if($_POST[$key]!="Save and Continue" && $_POST[$key]!="Submit Completed Application"){
			$database->addStudentRequ($_SESSION["ufid"],$_POST[$key]);
		}
	}
	redirect("studentApp5.php");
}

?>
<form action="studentApp3.php" method="POST"><p>
	<input type="submit" name="logout" value="Logout"/><br><br></p>
	<table border="1">
		<tr>
			<th>Abbreviation</th>
    		<th>Requirement</th>
    		<th>Select</th>    		
 		</tr>
<?php 
	$list=$database->listRequirements();
	$rcount =count($list);
	for($i=0;$i<$rcount;$i++){
		echo "<tr>";
		echo "<td>";
		echo $list[$i]["shortName"];
		echo "</td>";
		echo "<td>";
		echo $list[$i]["description"];
		echo "</td>";
		echo "<td>";
		
		If($database->checkStudentRequChecked($_SESSION["ufid"],$list[$i]["shortName"])==FALSE){
			echo "<input type='checkbox' name='".$list[$i]["shortName"]."' value='".$list[$i]["shortName"]."' />";
		}else{
			echo "<input type='checkbox' name='".$list[$i]["shortName"]."' value='".$list[$i]["shortName"]."' checked />";
		}
		echo "</td>";
		echo "</tr>";
	}
?>	
	</table>
	<input type="submit" name="save" value="Save and Continue"/>
<!-- 	<input type="submit" name="submit" value="Submit Completed Application"/> -->
</form>

<?php
 $database->disconnect();
?>

</body>
</html>