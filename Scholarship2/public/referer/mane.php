<?php require_once("refererheader.php"); ?>
<?php require_once("header.php"); 
if(isset($_POST)){
	foreach($_POST as $key => $value){
		if($_POST[$key]=="Complete Recommendation" or $_POST[$key]=="Edit"){
			$_SESSION["student"]=$key;
			redirect("recommendation.php");
		}
	}
}
?>
<form action="mane.php" method="POST">
	<input type="submit" name="logout" value="Logout">

<p>Below is the list of students who have requested recommendations from you.</p>

<?php 
	$list = $database->listStudentsForReferer($_SESSION["ufid"]);
	if($list==FALSE){
		echo "You have no students to refer.";
	}else{
		$rcount = count($list);
		echo "<table border=\"1\">";
		echo "<tr>";
		echo "<th>Student</th>";
		echo "</tr>";
		for($i=0;$i<$rcount;$i++){
			echo "<tr>";
			echo "<td>";
			echo $list[$i]["name"];
			echo "</td>";
			echo "<td>";
			echo "<input type=\"submit\" name=\"".$list[$i]["ufid"]."\" value=\"Complete Recommendation\" />";
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
?>

<br><br>
Below is a list of the students who you have already given recommendations to.<br>

<?php 
	$list = $database->listStudentsReferered($_SESSION["ufid"]);
	if($list==FALSE){
		echo "You have not given references for any students.";
	}else{
		echo "<table border=\"1\">";
		echo "<tr>";
		echo "<th>Student</th>";
		echo "</tr>";
		$rcount = count($list);
		for($i=0;$i<$rcount;$i++){
			echo "<tr>";
			echo "<td>";
			echo $list[$i]["name"];
			echo "</td>";
			echo "<td>";
			echo "<input type=\"submit\" name=\"".$list[$i]["ufid"]."\" value=\"Edit\" />";
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
?>


</form>



<?php
$database->disconnect();
?>


</body>
</html>