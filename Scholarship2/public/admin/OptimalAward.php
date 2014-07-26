<?php require_once("adminheader.php");
	require_once("header.php"); 
	require_once("../../includes/OS.php");
	use \WebDSS\OS;
	
	$allRequirements=$database->listRequirements();
	$allScholarships=$database->list_scholarship();
	$allStudents=$database->listStudents();

	       
	$requirementCount=count($allRequirements);
	$studentCount=count($allStudents);
	$scholarshipCount=count($allScholarships);
	
	$studentRequirementMet= array();
	$scholarshipRequirementMet=array();
	$scholarshipPreferenceMet=array();
	$scholarshipOrRequirementMet=array();
	
	for($m=0;$m<$requirementCount;$m++){
		for($i=0;$i<$studentCount;$i++){
			$studentRequirementMet[$i][$m]=$database->studentMetReq($allStudents[$i]["ufid"],$allRequirements[$m]["shortName"]);                   
		}
	}
	       
	       
	$m=0;
	for($m=0;$m<$requirementCount;$m++){
		for($j=0;$j<$scholarshipCount;$j++){
			$scholarshipRequirementMet[$j][$m]=$database->scholarshipMetReq($allScholarships[$j]["title"],$allScholarships[$j]["amount"],$allRequirements[$m]["shortName"]);
			$scholarshipOrRequirementMet[$j][$m]=$database->scholarshipMetOrReq($allScholarships[$j]["title"],$allScholarships[$j]["amount"],$allRequirements[$m]["shortName"]);
			$result=$database->scholarshipMetPref($allScholarships[$j]["title"],$allScholarships[$j]["amount"],$allRequirements[$m]["shortName"]);
			if($result==FALSE){
				$scholarshipPreferenceMet[$j][$m]=0;
			}else{
				$scholarshipPreferenceMet[$j][$m]=$result[0];
			}
		}
	}
	//objective function
	
	$i=0;
	$j=0;
	$m=0;
	$problem= new OS('max');
	$objectiveFunctionCoef=array();

	for($j=0;$j<$scholarshipCount;$j++){
		for($i=0;$i<$studentCount;$i++){
			$addPrefPoints=0;
			for($m=0;$m<$requirementCount;$m++){
				$addPrefPoints=$addPrefPoints+$scholarshipPreferenceMet[$j][$m]*$studentRequirementMet[$i][$m];
			}
			$score=0;
			$score=$allStudents[$i]["score"]+$addPrefPoints;
			$objectiveFunctionCoef[$i][$j]=$allScholarships[$j]["amount"]*$score;
			$problem->addVariable("St".$i." Sc".$j,$type='B');
			$problem->addObjCoef("St".$i." Sc".$j,$objectiveFunctionCoef[$i][$j]);
		}
	}
	
	//constraint 2 checking quantity for each scholarship
	$i=0;
	$j=0;
	for($j=0;$j<$scholarshipCount;$j++){
		$problem->addConstraint($allScholarships[$j]["quantity"]);
		for($i=0;$i<$studentCount;$i++){
			$problem->addConstraintCoef("St".$i." Sc".$j, 1);              
		}
		$problem->endConstraint();
	}

	//constraint 3 check student and scholarship requirements
	//constraint 4 check OR condition
	$i=0;
	$j=0;
	$m=0;
	$possibleWinners=array();	               
	for($j=0;$j<$scholarshipCount;$j++){
		for($i=0;$i<$studentCount;$i++){
			$constraintUB=0;
			$constraintCoef=0;
			$constraintOrUB=0;
			$orSum=0;
			for($m=0;$m<$requirementCount;$m++){
				$constraintUB=$studentRequirementMet[$i][$m]*$scholarshipRequirementMet[$j][$m]+$constraintUB;
				$constraintCoef=$constraintCoef+$scholarshipRequirementMet[$j][$m];
				$constraintOrUB=$studentRequirementMet[$i][$m]*$scholarshipOrRequirementMet[$j][$m]+$constraintUB;
				$orSum=$orSum+$scholarshipOrRequirementMet[$j][$m];
			}
			$problem->addConstraint($constraintUB);
			$problem->addConstraintCoef("St".$i." Sc".$j, $constraintCoef);
			//echo "St".$i." Sc".$j."<br>";
			$problem->endConstraint();
			if($orSum!=0){
				$problem->addConstraint($constraintOrUB);
				$problem->addConstraintCoef("St".$i." Sc".$j, 1);
				$problem->endConstraint();
			}
			if(($constraintOrUB>=1 OR $orSum==0) && $constraintUB==$constraintCoef){
				$possibleWinners[$j][]=$allStudents[$i];
			}
		}
	}

	//constraint 5 one student can only get two at most
	$i=0;
	$j=0;
	for($i=0;$i<$studentCount;$i++){
		$problem->addConstraint(2);
		for($j=0;$j<$scholarshipCount;$j++){
			$problem->addConstraintCoef("St".$i." Sc".$j, 1);
		}
		$problem->endConstraint();
	}
	
	//constraint 6 the schoarship that student applied for
	$i=0;
	$j=0;
	for($j=0;$j<$scholarshipCount;$j++){
		for($i=0;$i<$studentCount;$i++){
			$studentAppliedSch[$i][$j]=$database->studentAppSch($allStudents[$i]["ufid"],$allScholarships[$j]["title"],$allScholarships[$j]["amount"]);
		}
	}
	$i=0;
	$j=0;
	for($j=0;$j<$scholarshipCount;$j++){
 		//$problem->addConstraint($allScholarships[$j]["quantity"]);
		for($i=0;$i<$studentCount;$i++){						
			$problem->addConstraint($studentAppliedSch[$i][$j]);
			$problem->addConstraintCoef("St".$i." Sc".$j, 1);
			$problem->endConstraint();
		}
 		
 	}
 
	$problem->solve();
	$problem->getSolution();
	$variableSolution=$problem->getVariables();
	
	print_r($variableSolution);
?>

<form action="OptimalAward.php" method="POST">
	<p>
		<input type="submit" name="logout" value="Logout"/> &nbsp;
		<input type="submit" name="opt" value="Get Optimal Awarding"/>
	</p>
	
<?php 
	if(isset($_POST["opt"]) && $_POST["opt"]=="Get Optimal Awarding"){
		$database->clearWinners();
		for($j=0;$j<$scholarshipCount;$j++){
			for($i=0;$i<$studentCount;$i++){
				if($variableSolution["St".$i." Sc".$j]==1){
					$database->assignWinner($allScholarships[$j]["title"],$allScholarships[$j]["amount"],$allStudents[$i]["ufid"]);
				}
			}
		}
	}else{
	if(isset($_POST)&& !isset($_POST["logout"]) && !isset($_POST["done"]) && !isset($_POST["opt"])){
		foreach($_POST as $key => $value ) {
			if($_POST[$key]=="Remove"){
				$database->deleteWinner($_SESSION["scholar"],$_POST["removePerson"],$_SESSION["amount"]);
			}elseif($_POST[$key]=="Add"){
				$database->assignWinner($_SESSION["scholar"],$_SESSION["amount"],$_POST["addPerson"]);
			}elseif($_POST[$key]=="Change Winners"){
			echo "<hr>";
			echo "<h3>Edit Scholarship Winners</h3>";
			echo "<b>".$allScholarships[$key]["title"]."&nbsp;";
			echo $allScholarships[$key]["amount"]."</b><br>";
			$_SESSION["scholar"]=$allScholarships[$key]["title"];
			$_SESSION["amount"]=$allScholarships[$key]["amount"];
			$deleteList=array();
			$deleteList=$database->getWinners($allScholarships[$key]["title"],$allScholarships[$key]["amount"]);
			if($deleteList!=FALSE){
				$deleteCount=count($deleteList);
			}else{
				$deleteCount=0;
			}
			$results="";
			$possibleCount=count($possibleWinners[$key]);
			$possResults="";
			$addList=array();
			$arrayCount=0;
			for($j=0;$j<$possibleCount;$j++){
				$yesNo=0;
				for($i=0;$i<$deleteCount;$i++){
					if($possibleWinners[$key][$j]["ufid"]==$deleteList[$i]["ufid"]){
						$yesNo=1;
					}
				}				
				if($yesNo==0){					
					$addList[$arrayCount]["ufid"]=$possibleWinners[$key][$j]["ufid"];
					$addList[$arrayCount]["name"]=$possibleWinners[$key][$j]["name"];
					$arrayCount=$arrayCount+1;
				}
			}
			$addcount=count($addList);
			for ($k=0;$k<$addcount;$k++){
				$possResults=$possResults."<option value=\"".$addList[$k]["ufid"]."\">".$addList[$k]["name"]."</option>";
			}
			for($l=0;$l<$deleteCount;$l++){
				$results=$results."<option value=\"".$deleteList[$l]["ufid"]."\">".$deleteList[$l]["name"]."</option>";
			}
			echo "<b>Add a winner: </b>";
			if($possResults==""){
				echo "There are no other students who qualify for this scholarship.<br>";
			}else{
				echo "<select name=\"addPerson\">".$possResults."</select><input type=\"submit\" name=\"add\" value=\"Add\"/><br>";
			}
			echo "<b>Remove a winner: </b>";
			if($results==""){
				echo "No students have been awarded this scholarship.<br>";
			}else{
				echo "<select name=\"removePerson\">".$results."</select><input type=\"submit\" name=\"remove\" value=\"Remove\"/> ";
			}
			echo "<br><br><input type=\"submit\" name=\"done\" value=\"Done Editing\"/>";
			echo "<hr>";
			}
		}
	}
	}

?>	
<h3>Winners List</h3>
<?php 
	$totalWins=$database->getWinnersCount();
	$countWins=count($totalWins);
	for ($i=0;$i<$countWins;$i++){
		if($totalWins[$i]["count"]>2){
			echo "<font color=\"red\">Warning: You have awarded ".$totalWins[$i]["name"]." more than 2 scholarships!</font><br><br><br>";
		}
	}

?>
<table border="1">
	<tr>
		<th>Scholarship</th>
		<th>Award Amount</th>
		<th>Winners</th>
		<?php 
			if(isset($_POST["edit"])&&!empty($_POST["edit"])){
				echo "<th>Edit</th>";
			}
		?>
	</tr>
	<?php   
		$i=0;
		$j=0;
		for($j=0;$j<$scholarshipCount;$j++){
			echo "<tr>";
			echo "<td>".$allScholarships[$j]["title"]."</td>";
			echo "<td>".$allScholarships[$j]["amount"]."</td>";
			$winnerString="";
			$winnerList=$database->getWinners($allScholarships[$j]["title"],$allScholarships[$j]["amount"]);
			$winnerCount=count($winnerList);
			for($i=0;$i<$winnerCount;$i++){
				$winnerString=$winnerString.$winnerList[$i]["name"]."<br>";                     
			}
			echo "<td>".$winnerString."</td>";
			echo "<td><input type=\"submit\" name=\"".$j."\" value=\"Change Winners\"/></td>";
			echo "</tr>";
		}    
	?>
</table>
</form>
</body>
</html>


