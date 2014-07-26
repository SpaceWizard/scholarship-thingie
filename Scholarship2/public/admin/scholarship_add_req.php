<?php require_once("adminheader.php"); 
require_once("header.php");
if(isset($_POST["requirement"])&& isset($_POST["add"])&& $_POST["add"]="Add"){
	if($_SESSION["weight"] == 1) {
		$database->schAddReqOption(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"], $_POST["requirement"]);
	}
	else if($_SESSION["weight"] == 0) {
		$database->schAddReq(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"], $_POST["requirement"]);
	}
	//$database->schol_req_add(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"], $_POST["requirement"], $_SESSION["weight"]);
	//redirect("scholarship_requirements.php");	
}
if(isset($_POST["add"]) && $_POST["add"]=="Add New Requirement"){
	$database->add_req($_POST["shortName"], $_POST["description"]);
	$database->schol_req_add(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"], $_POST["shortName"], $_SESSION["weight"]);
	redirect("scholarship_requirements.php");
}

?>
<form action="scholarship_add_req.php" method="POST">
	<input type="submit" name="logout" value="Logout">
</form>

<?php 

	if(isset($_POST['new'])&& $_POST['new']="New"){
		echo "<form action=\"scholarship_add_req.php\" method=\"POST\">";
		echo "<label for=\"shortName\">Requirement Abreviation:&nbsp;</label><input type=\"text\" name=\"shortName\" id=\"shortName\"/><br><br>";
		echo "<label for=\"descrp\">Requirement Description:&nbsp;</label><input type=\"text\" name=\"description\" id=\"descrp\"/><br>";
		echo "<input type=\"submit\" name=\"add\" value=\"Add New Requirement\"/>";
		echo "</form>";
	}else{
		echo "<p> Select the new requirement for the ";
		echo str_replace("_"," ",$_SESSION["scholarship"])." ".$_SESSION["award"];
		echo " from the list below and click \"Add\". If the requirement you wish to add is not listed below then a new requirement must be added. You can do this by clicking the \"New\" button below.";
		echo "<form action=\"scholarship_add_req.php\" method=\"POST\">";

		$list = $database->list_requirements_Scholar_notUsed(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"]);
		$rcount =count($list);

		echo "<label for=\"req\">Requirement:&nbsp;</label>";
		echo "<select id=\"req\" name=\"requirement\">";

		for($i=0;$i<$rcount;$i++){
			echo "<option value=\"". $list[$i]["shortName"]."\">".$list[$i]["shortName"]." - ".$list[$i]["description"]."</option>";		
		}

		echo "</select><br>";
		echo "<input type=\"submit\" name=\"add\" value=\"Add\"/>&nbsp;<input type=\"submit\" name=\"new\" value=\"New\"/><br><br>";
		echo "</form>";
	}
?>




 <a href="scholarship_requirements.php"> Return to Scholarship Requirements Page</a>
 </body>
</html>