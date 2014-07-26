<?php require_once("adminheader.php"); ?>
<?php require_once("header.php"); ?>
<form action="AssignStudentComm.php" method="POST">
	<p><input type="submit" name="logout" value="Logout"><br><br></p>
<?php 
	if(isset($_POST["assign"])&& $_POST["assign"]="Assign"){
		$database->newStudentCommitteePair($_SESSION["studentID"],$_POST["Member"]);
	}

	if(isset($_POST)) {
		foreach($_POST as $key => $value ) {
			if($value == "Assign" && $key!="assign") {
				
				$_SESSION["studentID"]=$key;
				$name=$database->getStudentName($key);
				$count=$database->countCommMemByStudent($key);
				if($count[0]==1){				
					$listMem=$database->committeeMemNotAss($key);
				}else{
					$listMem=$database->listCommitteeMembers();
				}
				echo "<p>Choose a committee member to score ".$name[0];
				echo "<br>";
				echo "<select name=\"Member\">";
				$mcount =count($listMem);
				for($i=0;$i<$mcount;$i++){
					echo "<option value=\"".$listMem[$i]["ufid"]."\">".$listMem[$i]["ufid"]."</option>";
				}
				echo "</select>";
				echo "<input type=\"submit\" name=\"assign\" value=\"Assign\"/></p>";
			}
		}
	}
?>
	 
<p>The following is the list of students who still need to be assigned a committee member. Every student must have two committee members score each student application.";
<table border="1">
	<tr>
		<th>Student</th>
		<th>Assign</th>
	</tr>
<?php
	$list=$database->studentsNotAssigned();
	$rcount =count($list);
	for($i=0;$i<$rcount;$i++){
		echo "<tr>";
		echo "<td>";
		echo $list[$i]["studentName"];
		echo "</td>";
		echo "<td>";
		echo "<input type=\"submit\" name=\"".$list[$i]["ufid"]."\" value=\"Assign\"/>";
		echo "</td>";
		echo "</tr>";
	}
?>
</table>
<?php
 $database->disconnect();
?>
</form>
<a href="mane.php">Return to Main Page</a>
</body>
</html>