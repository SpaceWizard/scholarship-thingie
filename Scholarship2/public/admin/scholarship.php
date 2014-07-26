<?php require_once("adminheader.php"); ?> 
<?php require_once("header.php"); ?>
<?php
 	if(isset($_POST)&& !isset($_POST['add'])) {
 		foreach($_POST as $key => $value ) {
 			if($value == 'Edit' ) {
 				$list = $database->get_scholarships();
 				$_SESSION["scholarship"] = $list[$key]["title"];
				$_SESSION["award"]=$list[$key]["award"];

 				redirect("scholarshipedit.php");

 			}
 		}
 	}
 	If(isset($_POST['add']) && $_POST['add']="Add New Scholarship"){
 		redirect("addscholarship.php");
 	}
?>

<form action="scholarship.php" method="POST"><p>
	<input type="submit" name="logout" value="Logout">
	<input type="submit" name="add" value="Add New Scholarship"/>
</p></form>
<form action="scholarship.php" method="POST">
<?php 
	$list = $database->get_scholarships();
	$rcount =count($list);
?>

<table border="1">
	<tr>
		<th>Scholarship Name</th>
		<th>Award Amount</th>
	</tr>

<?php 
	for($i=0;$i<$rcount;$i++){
		echo "<tr>";		
		echo "<td>";
		echo $list[$i]["title"];
		echo "</td>";
		echo "<td>";
		echo $list[$i]["award"];
		echo "</td>";
		echo "<td>";
		echo "<input type='submit' name='".$i."' value='Edit' />";
		echo "</td>";
		echo "</tr>";
	}
?>
</table>


</form>
<p><a href="mane.php">Return to Main Admin Page</a></p>
<?php
 $database->disconnect();
?>

</body>
</html>