<?php require_once("committeeheader.php"); ?>
<?php require_once("header.php"); ?>
<?php
if(isset($_POST["assignScore"])) {
	foreach($_POST as $key => $value) {
		if($value != "Submit" && $value!=0){
			//if()
			$database->insertStudentScore($_SESSION["ufid"],$_SESSION["student"],$key ,$value);
			//die(json_encode)
			//redirect("mane.php");
		}
	}
}
?>
<?php //  
// 	if(isset($_POST["back"])&& $_POST['back']=="Back to Main Page")
// 		redirect(main.php);

// ?>

<div style="float:left; width:750px; margin-left:10px">
<form action="score.php" method="POST">
	<input type="submit" name="logout" value="Logout">
	
<?php 
	
echo "<br/>";
echo "<br/>";
$extraMaterial=$database->getStuExtraMaterial($_SESSION["student"]);
echo "<h3>Student Transcript:</h3>";

echo $extraMaterial["transcript"];
echo "<br/>";
echo "<br/>";
echo "<h3>Student Essay:</h3>";
echo "<br/>";
echo $extraMaterial["essay"];
echo "<br/>";
echo "<br/>";
echo "<h3>Student Resume:</h3>";
echo "<br/>";
echo $extraMaterial["resume"];
echo "<br/>";
echo "<br/>";

$extraMaterialForRecc=$database->getStuExtraMaterialForRecc($_SESSION["student"],"comments");

//print_r($extraMaterialForRecc);

echo "<h3>Letter from referer 1:</h3>";
echo "<br/>";
//echo $extraMaterialForRecc["comments"];
echo "<br/>";
echo "<br/>";
// echo "<h3>Letter from referer 2:</h3>";
// echo "<br/>";
// echo $extraMaterialForRecc["comments"];
// echo "<br/>";
// echo "<br/>";

?>

</div>	
<div style="float:left; width: 500px; margin-left:50px;">
<?php 
/*	$total=0;
    $itemList=array("GPA","GRE","Resume","Essay_Career","Essay_Interest","Recc1","Recc2");
	if(isset($_POST["assignScore"])&& $_POST['assignScore']=="Submit"){
	for($i=0;$i<count($itemList);$i++)
	{
	$database->insertStudentScore($_SESSION["ufid"],$_SESSION["student"],$itemList[$i],$_POST["$itemList[$i]"]);
	$total += $_POST["$itemList[$i]"];
	}
	$database->insertStudentScore($_SESSION["ufid"],$_SESSION["student"],"Total",$total);
	
}*/

?>


	<p>Below is the score card for <?php $name=$database->getStudentName($_SESSION["student"]); echo $name[0];?>'s application </p>
	<table border="1">
		<tr>
			<th>Item</th>
			<th>Current State</th>
			<th>Maximum Score</th>
			<th>Score</th>			
		<tr>
		<tr>
			<td>GPA</td>
			<td><?php $list=$database->getCurrentCommScore($_SESSION["ufid"],$_SESSION["student"],"GPA"); echo $list; if($list==FALSE){echo "Not Scored";}?></td>
			<td>20</td>
			<td><input type="text" name="GPA" value=""/></td>
		</tr>
		<tr>
			<td>GRE/SAT/ACT</td>
			<td><?php $list=$database->getCurrentCommScore($_SESSION["ufid"],$_SESSION["student"],"GRE"); echo $list;if($list==FALSE){echo "Not Scored";}?></td>
			<td>15</td>
			<td><input type="text" name="GRE" value=""/></td>
		</tr>
		<tr>
			<td>Resume</td>
			<td><?php $list=$database->getCurrentCommScore($_SESSION["ufid"],$_SESSION["student"],"Resume"); echo $list;if($list==FALSE){echo "Not Scored";}?></td>
			<td>10</td>
			<td><input type="text" name="Resume" value=""/></td>
		</tr>
		<tr>
			<td>Essay-Career Goals</td>
			<td><?php $list=$database->getCurrentCommScore($_SESSION["ufid"],$_SESSION["student"],"Essay_Career"); if($list==FALSE){echo "Not Scored";} else echo $list;?></td>
			<td>10</td>
			<td><input type="text" name="Essay_Career" value=""/></td>
		</tr>
		<tr>
			<td>Essay-Interest</td>
			<td><?php $list=$database->getCurrentCommScore($_SESSION["ufid"],$_SESSION["student"],"Essay_Interest"); if($list==FALSE){echo "Not Scored";} else {echo $list;}?></td>
			<td>10</td>
			<td><input type="text" name="Essay_Interest" value=""/></td>
		</tr>
		<tr>
			<td>Reccomendation Letter1</td>
			<td><?php $list=$database->getCurrentCommScore($_SESSION["ufid"],$_SESSION["student"],"Recc1"); if($list==FALSE){echo "Not Scored";} else echo $list;?></td>
			<td>10</td>
			<td><input type="text" name="Recc1" value=""/></td>
		</tr>
		<tr>
			<td>Reccomendation Letter2</td>
			<td><?php $list=$database->getCurrentCommScore($_SESSION["ufid"],$_SESSION["student"],"Recc2"); if($list==FALSE){echo "Not Scored";} else echo $list;?></td>
			<td>10</td>
			<td><input type="text" name="Recc2" value=""/></td>
		</tr>
		<tr>
			<td><b>Total Score</b></td>
			<td><b><?php $list=$database->getCurrentCommScore($_SESSION["ufid"],$_SESSION["student"]); if($list==FALSE){echo "Not Scored";} else echo $list;?></b></td>
			<td><b>85</b></td>
			
		</tr>
	</table>
	<br>
			<input type="submit" name="assignScore" value="Submit"/>
			
	
			<a href="mane.php">return to main page</a>
	
</form>
</div>

<?php
$database->disconnect();
?>
</body>
</html>