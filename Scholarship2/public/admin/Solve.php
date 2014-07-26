<?php require_once("adminheader.php");
	require_once("header.php"); 
	
	if(isset($_POST["assgin"])) {
		$database->assignWinner($_POST["scholarship"],$_POST["amount"],$_POST["student"]);
		redirect("#".$_POST["scholarship"].$_POST["amount"]);
	}
	else if(isset($_POST["remove"])) {
		$database->deleteWinner($_POST["scholarship"],$_POST["student"],$_POST["amount"]);
		redirect("#".$_POST["scholarship"].$_POST["amount"]);
	}
	$allScholarships = $database->list_scholarship();
	$allStudents = $database->listStudents();
	
	$database->pickEligibles();
	
	for($i=0;$i<count($allScholarships);$i++) {
		if(!$database->checkSchWithReq($allScholarships[$i]["title"],$allScholarships[$i]["amount"])) {
			for($j=0;$j<count($allStudents);$j++) {
				$database->addEligible($allScholarships[$i]["title"],$allScholarships[$i]["amount"],$allStudents[$j]["ufid"]);
			}
		}
	}
	
	$database->setBouns();
	$database->getStuApplied();
	//$eligibles = $database->getEligible();
	$eligibles = $database->getApp();
	/*for($i=0;$i<count($eligibles);$i++) {
		if(!in_array($eligibles[$i],$applied)) {
			//unset($eligibles[$i]);
		}
	}*/
	
	//die(json_encode($eligibles));
	
	use \WebDSS\OS;
	$os = new OS('max');
	
	foreach($eligibles as $key => $content) {
		$os->addVariable($key,$type='B');
		$os->addObjCoef($key, $content["AwardAmount"]*($database->getRefScore($content["Student"])+$database->getComScore($content["Student"])+$database->getBouns($content["ScholarshipName"],$content["AwardAmount"],$content["Student"])));
		//echo $key."<br/>";
	}
	
	//echo "<hr/>";
	
	for($i=0;$i<count($allScholarships);$i++) {
		$temp_eligible = $database->getApp($allScholarships[$i]["title"],$allScholarships[$i]["amount"]);
		//die(json_encode($temp_eligible));
		$os->addConstraint($allScholarships[$i]["quantity"]);
		//echo $allScholarships[$i]["quantity"]." ehit:";
		for($j=0;$j<count($temp_eligible);$j++) {
			$os->addConstraintCoef(array_search(array("ScholarshipName" => $allScholarships[$i]["title"], "AwardAmount" => $allScholarships[$i]["amount"], "Student" => $temp_eligible[$j]["Student"]),$eligibles),1);
			//echo array_search(array("ScholarshipName" => $allScholarships[$i]["title"], "AwardAmount" => $allScholarships[$i]["amount"], "Student" => $temp_eligible[$j]["Student"]),$eligibles);
		}
		$os->endConstraint();
		//echo "<hr/>";
	}
	
	//echo "<hr/>";
	
	for($i=0;$i<count($allStudents);$i++) {
		$temp_eligible = $database->getApp(NULL,NULL,$allStudents[$i]["ufid"]);
		//die(json_encode($temp_eligible));
		$os->addConstraint(2);
		for($j=0;$j<count($temp_eligible);$j++) {
			$os->addConstraintCoef(array_search(array("ScholarshipName" => $temp_eligible[$j]["ScholarshipName"], "AwardAmount" => $temp_eligible[$j]["AwardAmount"], "Student" => $allStudents[$i]["ufid"]),$eligibles),1);
			//echo array_search(array("ScholarshipName" => $temp_eligible[$j]["ScholarshipName"], "AwardAmount" => $temp_eligible[$j]["AwardAmount"], "Student" => $allStudents[$i]["ufid"]),$eligibles);
		}
		$os->endConstraint();
		//echo "<hr/>";
	}
	$os->solve();
	
	$result = $os->getVariables();
	
	//die((json_encode($result)));
	
	echo "<b>instructions: reds are students that does not meet requirements, greens are the optimal solutions<br/>hover mouse over an entry to see details<br/><br/></b>";
	
	echo "<a name='index'>";
		for($i=0;$i<count($allScholarships);$i++) {
			echo "<a href='"."#".$allScholarships[$i]["title"].$allScholarships[$i]["amount"]."'>Assgin students to: ".$allScholarships[$i]["amount"]." worth of ".$allScholarships[$i]["title"]."</a><br/>";
		}
	echo "</a>";
	
	for($i=0;$i<count($allScholarships);$i++) {
		//echo "reds are students that does not meet requirements, greens are the optimal solutions";
		echo "<a name='".$allScholarships[$i]["title"].$allScholarships[$i]["amount"]."'>";
		echo "<h3>Assgin students to: ".$allScholarships[$i]["amount"]." worth of ".$allScholarships[$i]["title"]."</h3>";
		echo "Scholarship Assigned: ";
		if($database->getWinners($allScholarships[$i]["title"],$allScholarships[$i]["amount"]))  
			echo count($database->getWinners($allScholarships[$i]["title"],$allScholarships[$i]["amount"]));
		else echo "0"; 
		echo "/".$allScholarships[$i]["quantity"];
		for($j=0;$j<count($allStudents);$j++) {
			if(!in_array(array("ScholarshipName" => $allScholarships[$i]["title"], "AwardAmount" => $allScholarships[$i]["amount"], "Student" => $allStudents[$j]["ufid"]),$eligibles)) {
				$color = "red";
			}
			else if($result[array_search(array("ScholarshipName" => $allScholarships[$i]["title"], "AwardAmount" => $allScholarships[$i]["amount"], "Student" => $allStudents[$j]["ufid"]),$eligibles)] ==1) {
				$color = "green";
			}
			else {
				$color = "black";
			}
			echo "<form action='Solve.php' method='post' >";
			echo "<a class='".$color."' title='".
				"committee score: ".$database->getComScore($allStudents[$j]["ufid"])." referer score: ".$database->getRefScore($allStudents[$j]["ufid"])." bouns score: ".$database->getBouns($allScholarships[$i]["title"],$allScholarships[$i]["amount"],$allStudents[$j]["ufid"])."'
			>Assign this scholarship to ".$allStudents[$j]["ufid"]."</a>";
			echo "<input type='hidden' name='scholarship' value='".$allScholarships[$i]["title"]."' />";
			echo "<input type='hidden' name='amount' value='".$allScholarships[$i]["amount"]."' />";
			echo "<input type='hidden' name='student' value='".$allStudents[$j]["ufid"]."' />";
			if($database->getWinners($allScholarships[$i]["title"],$allScholarships[$i]["amount"])) {
				if(in_array(array("ufid" => $allStudents[$j]["ufid"], "name" => $allStudents[$j]["name"]),$database->getWinners($allScholarships[$i]["title"],$allScholarships[$i]["amount"]))) {
					echo "<input type='submit' name='remove' value='remove' />";
				}
				else {
					echo "<input type='submit' name='assgin' value='assign' />";
				}
			}
			else {
				echo "<input type='submit' name='assgin' value='assign' />";
			}
			echo "</form>";
			}
		echo "<a href=#index>return to top</a>";
		echo "</a>";
		echo "<hr/>";
	}
	
	$database->dropTemps();
	
	$database->disconnect();
?>	
<a href="mane.php">return to main page </a>
</body>
</html>