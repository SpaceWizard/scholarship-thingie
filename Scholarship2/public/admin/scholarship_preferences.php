<?php require_once("adminheader.php"); 
require_once("header.php");
if(isset($_POST)&& !isset($_POST['add'])) {
	foreach($_POST as $key => $value ) {
		if($value == 'Delete' ) {
			$list = $database->list_scholarship_pref(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"]);
			$req = $list[$key]["preference"];
			$database->delete_scholarship_pref(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"], $req);
			redirect("scholarship_preferences.php");				
		}
	}
}
if(isset($_POST["add"])&&$_POST["add"]="Add Preference"){
	redirect("scholarship_add_pref.php");
}
?>
<form action="scholarship_preferences.php" method="POST"><p>
	<input type="submit" name="logout" value="Logout">
</p></form>
<p>Below is a list of <?php echo str_replace("_"," ",$_SESSION["scholarship"])." ". $_SESSION["award"];?> 's preferences. The weight illustrates the importance of that preference. </p>
<form action="scholarship_preferences.php" method="POST">
<?php
	$list = $database->list_scholarship_pref(str_replace("_"," ",$_SESSION["scholarship"]), $_SESSION["award"]);
	$count = 0;
	$rcount =count($list);
	If ($list!=FALSE){
		echo "<table border=\"1\">";
		echo "<tr>";
		echo "<th>Preference Abreviation</th>";
		echo "<th>Preference Description</th>";
		echo "<th>Preference Weight</th>";
		echo "</tr>";
		for($i=0;$i<$rcount;$i++){
			echo "<tr>";
			echo "<td>";
			echo $list[$i]["preference"];
			echo "</td>";
			echo "<td>";
			echo $list[$i]["description"];
			echo "</td>";
			echo "<td>";
			echo $list[$i]["weight"];
			echo "</td>";
			echo "<td>";
			echo "<input type='submit' name='".$i."' value='Delete' />";
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}else{
		echo "There are no preferences for ", str_replace("_"," ",$_SESSION["scholarship"])." ".$_SESSION["award"], "<br>";
	}

?>

<input type="submit" name="add" value="Add Preference"/><br><br>
</form>


<a href="scholarshipedit.php"> Return to Scholarship Edit Page</a>
<?php
$database->disconnect();
?>
</body>
</html>
