<?php require_once("adminheader.php"); 
require_once("header.php");

if(isset($_POST["preference"])&& isset($_POST["add"])&& $_POST["add"]="Add" && isset($_POST["weight"]) && $_POST["weight"]!=""){

	$database->schol_pref_add(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"], $_POST["preference"], $_POST["weight"]);
	redirect("scholarship_preferences.php");	
}
if(isset($_POST["add"]) && $_POST["add"]=="Add New Preference"){
	
	$database->add_req($_POST["shortName"], $_POST["description"]);
	$database->schol_pref_add(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"], $_POST["shortName"], $_POST["weight"]);
	redirect("scholarship_preferences.php");
}

?>
<form action="scholarship_add_pref.php" method="POST">
	<input type="submit" name="logout" value="Logout">
</form>

<?php 

	if(isset($_POST['new'])&& $_POST['new']="New"){
		echo "<form action=\"scholarship_add_pref.php\" method=\"POST\">";
		echo "<label for=\"shortName\">Preference Abreviation:&nbsp;</label><input type=\"text\" name=\"shortName\" id=\"shortName\"/><br><br>";
		echo "<label for=\"descrp\">Preference Description:&nbsp;</label><input type=\"text\" name=\"description\" id=\"descrp\"/><br><br>";
		echo "<label for=\"weight\">Preference Weight:&nbsp;</label><input type=\"text\" name=\"weight\" id=\"weight\"/><br>";
		echo "<input type=\"submit\" name=\"add\" value=\"Add New Preference\"/>";
		echo "</form>";
	}else{
		echo "<p> Select the new preference for the ";
		echo str_replace("_"," ",$_SESSION["scholarship"])." ".$_SESSION["award"];
		echo " from the list below, add a weight and click \"Add\". If the preference you wish to add is not listed below then a new preference must be added. You can do this by clicking the \"New\" button below. \n";
		echo "<form action=\"scholarship_add_pref.php\" method=\"POST\"> \n <p>";

		$list = $database->list_possible_pref(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"]);
		$rcount =count($list);

		echo "<label for=\"pref\">Prefernces:&nbsp;</label> \n";
		echo "<select id=\"pref\" name=\"preference\"> \n";

		for($i=0;$i<$rcount;$i++){
			echo "<option value=\"". $list[$i]["shortName"]."\">".$list[$i]["shortName"]." - ".$list[$i]["description"]."</option> \n";		
		}

		echo "</select> \n";
		echo "<label for=\"weight\">Weight:&nbsp;</label> \n";
		echo "<input type=\"text\" name=\"weight\" id=\"weight\"/><br> \n";
		echo "<input type=\"submit\" name=\"add\" value=\"Add\"/>&nbsp;<input type=\"submit\" name=\"new\" value=\"New\"/><br><br> \n";
		echo "</p> </form>";
	}
?>


 <a href="scholarship_preferences.php"> Return to Scholarship Preference Page</a>
 </body>
</html>
