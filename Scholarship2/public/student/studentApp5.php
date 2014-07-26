
<?php require_once("stuheader.php"); ?>


<?php  ?>

<?php require_once("header.php"); 

if(isset($_POST)) {
	foreach($_POST as $key => $value ) {
		if($_POST[$key]!="Save and Finish Later" && $_POST[$key]!="Submit Completed Application"){
			//die ("ufid".$_SESSION["ufid"]."key".str_replace("_"," ",$key)."value".$value."<br/>");
			//echo "ufid".$_SESSION["ufid"]."key".$key."value".$value."<br/>";
			$database->addStudentAppSch($_SESSION["ufid"],str_replace("_"," ",$key),$_POST[$key]);
		}
	}
}
if(isset($_POST["submit"])){
	$database->deleteAllStudAppSch($_SESSION["ufid"]);
	foreach($_POST as $key => $value ) {
		if($_POST[$key]!="Save and Finish Later" && $_POST[$key]!="Submit Completed Application"){
			$database->addStudentAppSch($_SESSION["ufid"],str_replace("_"," ",$key),$_POST[$key]);	
		}
	}
	$database->completeApp($_SESSION["ufid"]);
	redirect("mane.php");
}
if(isset($_POST["save"])){
	$database->deleteAllStudAppSch($_SESSION["ufid"]);
	foreach($_POST as $key => $value ) {
		if($_POST[$key]!="Save and Finish Later" && $_POST[$key]!="Submit Completed Application"){
			$database->addStudentAppSch($_SESSION["ufid"],str_replace("_"," ",$key),$_POST[$key]);
		}
	}
	redirect("mane.php");
}

?>
<form action="studentApp5.php" method="POST"><p>
	<input type="submit" name="logout" value="Logout"/><br><br></p>
	<table border="1">
		<tr>
			<th>Scholarship</th>
    		<th>Award</th>
  <!-- 		<th>Quantity</th>    -->
    		<th>Select</th> 		
 		</tr>
<?php 
	$allScholarships = $database->list_scholarship();
	
	//die(json_encode($database->getEligible(NULL,NULL,"applejack")));
	
	$database->pickEligibles();
	
	for($i=0;$i<count($allScholarships);$i++) {
		if(!$database->checkSchWithReq($allScholarships[$i]["title"],$allScholarships[$i]["amount"])) {
			$database->addEligible($allScholarships[$i]["title"],$allScholarships[$i]["amount"],$_SESSION["ufid"]);
		}
	}
	
	$list = $database->getEligible(NULL,NULL,$_SESSION["ufid"]);
	//$list=$database->list_scholarship(); 
	$rcount =count($list);
	for($i=0;$i<$rcount;$i++){
		echo "<tr>";
		echo "<td>";
		echo $list[$i]["ScholarshipName"];
		echo "</td>";
		echo "<td>";
		echo $list[$i]["AwardAmount"];
		echo "</td>";
		//echo "<td>";
		//echo $list[$i]["quantity"];
		//echo "</td>";
		echo "<td>";
		
		If($database->checkStudentSchChecked($_SESSION["ufid"],$list[$i]["ScholarshipName"],$list[$i]["AwardAmount"])==FALSE){
			echo "<input type='checkbox' name='".$list[$i]["ScholarshipName"]."' value='".$list[$i]["AwardAmount"]."' />";
		}else{
			echo "<input type='checkbox' name='".$list[$i]["ScholarshipName"]."' value='".$list[$i]["AwardAmount"]."' checked />";
		}
		echo "</td>";
		echo "</tr>";
		echo "</td>";
		echo "</tr>";
	}
?>	
	</table>
	<input type="submit" name="save" value="Save and Finish Later"/>
	<input type="submit" name="submit" value="Submit Completed Application"/>
</form>

<?php
 $database->disconnect();
?>

</body>
</html>