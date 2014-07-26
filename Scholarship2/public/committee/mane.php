<?php require_once("committeeheader.php"); ?>
<?php require_once("header.php"); ?>
<?php
if(isset($_POST)) {
 	foreach($_POST as $key => $value) {
 		if($_POST[$key]=="Score" or $_POST[$key]=="Change"){
 			$_SESSION["student"]=$key;
 			redirect("score.php");
 		}
 	}
}
?>

<form action="mane.php" method="POST">
	<input type="submit" name="logout" value="Logout"><br><br>
</form>

<form action="mane.php" method="POST">
<p>Below is the list of student applications you still must score.</p>
<?php 
	$list = $database->listStudentForCommNotScore($_SESSION["ufid"]);
	$rcount = count($list);
	if($list!=FALSE){
		echo "<table border=\"1\">";
		echo "<tr>";
		echo "<th>";
		echo "Student";
		echo "</th>";
		echo "</tr>";
		for($i=0;$i<$rcount;$i++) {
			echo "<tr>";
			echo "<td>";
			$name = $database->getStudentName($list[$i]["ufid"]);
			echo $name[0];
			echo "</td>";
			echo "<td>";
			echo "<input type=\"submit\" name='".$list[$i]["ufid"]."' value='Score' />";
			echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}else{
		echo "You have no applications to score.";
	}
?>
<br>
<p>Below is the list of student applications you have already scored.</p>
<?php 
	$list2 = $database->listStudentForCommScore($_SESSION["ufid"]);
	$rcount2 = count($list2);
	if($list2!=FALSE){
		echo "<table border=\"1\">";
		echo "<tr>";
		echo "<th>";
		echo "Student";
		echo "</th>";
		echo "<th>";
		echo "Score";
		echo "</th>";
		echo "</tr>";
		for($i=0;$i<$rcount2;$i++) {
			echo "<tr>";
			echo "<td>";
			$name = $database->getStudentName($list2[$i]["ufid"]);
			echo $name[0];
			echo "</td>";
			echo "<td>";
			echo $list2[$i]["score"];
			echo "</td>";
			echo "<td>";
			echo "<input type=\"submit\" name='".$list2[$i]["ufid"]."' value='Change' />";
			echo "</tr>";
		}
		echo "</table>";
	}else{
		echo "You have not scored any applications.";
	}
?>


</form>
<?php
$database->disconnect();
?>
</body>
</html>