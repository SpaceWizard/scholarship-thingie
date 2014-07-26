<?php require_once("adminheader.php"); 
 		require_once("header.php"); 

 if(isset($_POST)&& !isset($_POST['add'])) {
 	foreach($_POST as $key => $value ) {
 		if($value == 'Delete' ) {
 			$list = $list = $database->list_scholarships_requirements(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"]);
			$req = $list[$key]["shortName"];
			/*$database->delete_scholarship_requirement(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"], $req);
 			redirect("scholarship_requirements.php");*/
			$database->removeSchReq(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"], $_POST["req"]);
 		}elseif($value=='Delete Option'){
 			$list2 = $database->list_or_scholarship_requirements(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"]);
			//die(json_encode($list2));
 			$req2=$list2[$key]["shortName"];
 			/*$database->delete_scholarship_requirement(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"], $req2);
 			redirect("scholarship_requirements.php");*/
			$database->removeSchReq(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"], $_POST["opt"]);
 		}
 	}
 }

 if(isset($_POST["Add"])){
 	if($_POST["Add"]=="Add Requirement"){
 		$_SESSION["weight"]=0;
 		redirect("scholarship_add_req.php");
 	}elseif($_POST["Add"]=="Add Option"){
 		$_SESSION["weight"]=1;
 		redirect("scholarship_add_req.php");
 	}
 }
?>
<form action="scholarship_requirements.php" method="POST"><p>
	<input type="submit" name="logout" value="Logout">
</p></form>
<p> Below is a list of <?php echo str_replace("_"," ",$_SESSION["scholarship"])." ". $_SESSION["award"];?> 's requirements. These are the requirements that all applicants must meet. </p> 		



<?php 
$list2 = $database->list_or_scholarship_requirements(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"]);
//die($_SESSION["scholarship"]."  ".$_SESSION["award"]);
//die(json_encode($list2));
$count = 0;
$rcount2 =count($list2);
If ($list2!=FALSE){
	echo "<table border=\"1\">";
	echo "<tr>";
	echo "<th>Requirement Abreviation</th>";
	echo "<th>Requirement Description</th>";
	echo "</tr>";
	for($i=0;$i<$rcount2;$i++){
		echo "<tr>";		
		echo "<td>";
		echo $list2[$i]["shortName"];
		echo "</td>";
		echo "<td>";
		echo $list2[$i]["description"];
		echo "</td>";
		echo "<td>";
		echo "<form action='scholarship_requirements.php' method='POST'>";
		echo "<input type='hidden' name='req' value='".$list2[$i]["shortName"]."' />";
		echo "<input type='submit' name='".$i."' value='Delete' />";
		echo "</form>";
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
}else{
	echo "There are no requirements in this category for ", str_replace("_"," ",$_SESSION["scholarship"]), "<br>";
}
?>

<form action="scholarship_requirements.php" method="POST">

<input type="submit" name="Add" value="Add Requirement"/>

</form>
<p>Listed below are also constraints for <?php echo str_replace("_"," ",$_SESSION["scholarship"])." ". $_SESSION["award"];?>. However the applicant must meet at least one of the requirements listed below not all of them. </p>

<?php
$list = $database->list_scholarships_requirements(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"]);
$rcount =count($list);

If ($list!="none"){
	echo "<table border=\"1\">";
	echo "<tr>";
	echo "<th>Requirement Abreviation</th>";
	echo "<th>Requirement Description</th>";
	echo "</tr>";
	for($i=0;$i<$rcount;$i++){
		echo "<tr>";
		echo "<td>";
		echo $list[$i]["shortName"];
		echo "</td>";
		echo "<td>";
		echo $list[$i]["description"];
		echo "</td>";
		echo "<td>";
		echo "<form action='scholarship_requirements.php' method='POST'>";
		echo "<input type='hidden' name='opt' value='".$list[$i]["shortName"]."' />";
		echo "<input type='submit' name='".$i."' value='Delete Option' />";
		echo "</form>";
		echo "</td>";
		echo "</tr>";
	}

	echo "</table>";
}else{
	echo "There are no requirements in this category for ", str_replace("_"," ",$_SESSION["scholarship"]), "<br>";
}
?>

<form action="scholarship_requirements.php" method="POST">

<input type="submit" name="Add" value="Add Option"/><br><br>

</form>

<a href="scholarshipedit.php"> Return to Scholarship Edit Page</a>
<?php
$database->disconnect();
?>
</body>
</html>