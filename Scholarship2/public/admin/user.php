<?php require_once("adminheader.php"); ?> 
<?php
if(count($_POST)!=0 && $_POST['add']!="Add New User"){
	foreach($_POST as $key => $value) {	
		if(isset($key)) {
			$_SESSION["user"] = $key;
			redirect("useredit.php");
		}
	}
}

if($_POST['add']="Add New User" && isset($_POST['add'])){
	redirect("adduser.php");
}
?>
<?php require_once("header.php"); ?>
<form action="user.php" method="POST">
	<p>
	<input type="submit" name="logout" value="Logout">
	</p>
</form>
<form action="user.php" method="POST">

<?php 
$result = $database->get_users();
$rcount = count($result);
echo "<table>";
echo "<tr>";
echo "<th>";
echo "Usernames";
echo "</th>";
echo "<th>";
echo "Classes";
echo "</th>";
echo "</tr>";
for($i=0;$i<$rcount;$i++) {
	echo "<tr>";
	echo "<td>";
	echo $result[$i]["ufid"];
	echo "</td>";
	echo "<td>";
	echo $result[$i]["class"];
	echo "</td>";
	echo "<td>";
	echo "<input type=\"submit\" name='".$result[$i]["ufid"]."' value='Edit' />";
	echo "</td>";
	echo "</tr>";
}
echo "</table>";
?>
<p>
<input type="submit" name="add" value="Add New User"/>
</p>
</form>
<p>
<a href="mane.php">Return to Main Admin Page</a>
</p>
<?php
$database->disconnect();
?>
</body>
</html>