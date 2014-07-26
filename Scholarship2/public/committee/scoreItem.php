<?php 
	require_once("committeeheader.php");
	require_once("header.php"); 

	if(isset($_POST["submit"]) && !empty($_POST["submit"])){
		$database->clearStudCommScore($_SESSION["student"],$_SESSION["ufid"],$_SESSION["item"]);
		$database->newStudCommScore($_SESSION["student"],$_SESSION["ufid"],$_SESSION["item"],$_POST["score"]);
		redirect("score.php");
	}	
?>

<form action="scoreItem.php" method="POST">
	<input type="submit" name="logout" value="Logout">
	<p>You are currently scoring <?php $name=$database->getStudentName($_SESSION["student"]); echo $name[0];?>'s application.</p>
	<hr>
<?php 
	if($_SESSION["item"]=="GPA"){
		echo "Displayed below is ".$name[0]."'s GPA <br><br>";
		$item=$database->getStudentGPA($_SESSION["student"]); 
		echo $item. "<br><hr>";
	}elseif ($_SESSION["item"]=="GRE"){
		echo "Displayed below is ".$name[0]."'s GRE, SAT, or ACT score <br><br>";
		$item=$database->getStudentGRE($_SESSION["student"]);
		echo $item. "<br><hr>";
	}elseif ($_SESSION["item"]=="Resume"){
		echo "Displayed below is ".$name[0]."'s Resume<br><br>";
		$item=$database->getSavedAddMat($_SESSION["student"]);
		echo "<textarea rows=\"20\" cols=\"100\" readonly>";
		echo $item["resume"];
		echo "</textarea>";
	}elseif ($_SESSION["item"]=="Essay_Career"){
		echo "Displayed below is ".$name[0]."'s Essay<br><br>";
		$item=$database->getSavedAddMat($_SESSION["student"]);
		echo "<textarea rows=\"20\" cols=\"100\" readonly>";
		echo $item["essay"];
		echo "</textarea>";
	}elseif ($_SESSION["item"]=="Essay_Interest"){
		echo "Displayed below is ".$name[0]."'s Essay<br><br>";
		$item=$database->getSavedAddMat($_SESSION["student"]);
		echo "<textarea rows=\"20\" cols=\"100\" readonly>";
		echo $item["essay"]. "<br><hr>";
		echo "</textarea>";
	}elseif ($_SESSION["item"]=="Recc1"){
		echo "Displayed below is ".$name[0]."'s first recommendation<br><br>";
		$referer=$database->getStuRef($_SESSION["student"]);
		echo "Recommendation made by ".$referer[0]["name"];
		echo "<table border=\"1\"><tr><th>Candidate Evaluation</th><th>Score</th></tr><tr><td>Commitment to professional growth/development</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"growth")."</td></tr>";
		echo "<tr><td>Competence in chosen field</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"competence")."</td></tr>";;
		echo "<tr><td>Motivation/Initiative</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"motivation")."</td></tr>";;
		echo "<tr><td>Academic Performance</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"academic")."</td></tr>";;
		echo "<tr><td>Intellectual ability/critical thinking skills</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"intellectual")."</td></tr>";;
		echo "<tr><td>Potential as a professional in chosen field</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"potential")."</td></tr>";;
		echo "<tr><td>Leadership</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"leadership")."</td></tr>";;
		echo "<tr><td>Quality of work</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"quality")."</td></tr>";;
		echo "<tr><td>Emotional maturity</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"maturity")."</td></tr>";;
		echo "<tr><td>Research aptitude/potential</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"research")."</td></tr>";;
		echo "<tr><td>Written communication shills</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"written")."</td></tr>";;
		echo "<tr><td>Oral communication skills</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"oral")."</td></tr>";;
		echo "<tr><td>Attention to important details</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"attention")."</td></tr>";;
		echo "<tr><td>Creativity/innovation</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"creativity")."</td></tr>";;
		echo "<tr><td>Enthusiasm for learning, teaching, and/or research</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"enthusiasm")."</td></tr>";;
		echo "<tr><td>Volunteerism</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"volunteerism")."</td></tr>";;
		echo "<tr><td>Dependability/reliability</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"dependability")."</td></tr>";;
		echo "<tr><td>Overall Evaluation: Compared with a representative group of students <br>at the same academic level, this student's GENERAL ALL-AROUND ABILITY <br>would rank in the top:</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"overall")."%</td></tr>";;
		echo "</table><br><table>";
		echo "<tr><td>How long have you known the candidate?</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"length")."</td></tr>";
		echo "<tr><td>In what capacity do you know the candidate?</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"capacity")."</td></tr>";
		echo "</table><br>";
		echo "Additional Comments:<br>";
		echo "<textarea rows=\"5\" cols=\"80\" readonly>";
		echo $database->getRefForStudent($_SESSION["student"],$referer[0]["ufid"],"comments");
		echo "</textarea><br>";
		
	}elseif ($_SESSION["item"]=="Recc2"){
		echo "Displayed below is ".$name[0]."'s second recommendation<br><br>";
		$referer=$database->getStuRef($_SESSION["student"]);
		echo "Recommendation made by ".$referer[1]["name"];
		echo "<table border=\"1\"><tr><th>Candidate Evaluation</th><th>Score</th></tr><tr><td>Commitment to professional growth/development</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"growth")."</td></tr>";
		echo "<tr><td>Competence in chosen field</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"competence")."</td></tr>";;
		echo "<tr><td>Motivation/Initiative</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"motivation")."</td></tr>";;
		echo "<tr><td>Academic Performance</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"academic")."</td></tr>";;
		echo "<tr><td>Intellectual ability/critical thinking skills</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"intellectual")."</td></tr>";;
		echo "<tr><td>Potential as a professional in chosen field</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"potential")."</td></tr>";;
		echo "<tr><td>Leadership</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"leadership")."</td></tr>";;
		echo "<tr><td>Quality of work</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"quality")."</td></tr>";;
		echo "<tr><td>Emotional maturity</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"maturity")."</td></tr>";;
		echo "<tr><td>Research aptitude/potential</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"research")."</td></tr>";;
		echo "<tr><td>Written communication shills</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"written")."</td></tr>";;
		echo "<tr><td>Oral communication skills</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"oral")."</td></tr>";;
		echo "<tr><td>Attention to important details</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"attention")."</td></tr>";;
		echo "<tr><td>Creativity/innovation</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"creativity")."</td></tr>";;
		echo "<tr><td>Enthusiasm for learning, teaching, and/or research</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"enthusiasm")."</td></tr>";;
		echo "<tr><td>Volunteerism</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"volunteerism")."</td></tr>";;
		echo "<tr><td>Dependability/reliability</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"dependability")."</td></tr>";;
		echo "<tr><td>Overall Evaluation: Compared with a representative group of students <br>at the same academic level, this student's GENERAL ALL-AROUND ABILITY <br>would rank in the top:</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"overall")."%</td></tr>";;
		echo "</table><br><table>";
		echo "<tr><td>How long have you known the candidate?</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"length")."</td></tr>";
		echo "<tr><td>In what capacity do you know the candidate?</td><td>".$database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"capacity")."</td></tr>";
		echo "</table><br>";
		echo "Additional Comments:<br>";
		echo "<textarea rows=\"5\" cols=\"80\" readonly>";
		echo $database->getRefForStudent($_SESSION["student"],$referer[1]["ufid"],"comments");
		echo "</textarea><br>";
	}
?>
	<hr>
	<p>Based on the criteria below how would you score <?php echo $name[0]; 
		if($_SESSION["item"]=="Essay_Career"){
			echo "<br> Please score the essay based on if career goals were clearly stated and the essay shows how study at UF relates to those goals.";
		}elseif($_SESSION["item"]=="Essay_Interest"){
			echo "<br> Please score the essay based on whether evidence of interest in, commitment to and/or potential for leadership in Education is apparent from the essay..";
		}
	
	?>	
	
	<table border="1">
		<tr>
			<th>Criteria</th>
			<th>Score</th>
		</tr>
		<?php 
			$scoreCriteria=$database->getScoreCriteria($_SESSION["item"]);
			$critCount=count($scoreCriteria);
			for($i=0;$i<$critCount;$i++) {
				echo "<tr>";
				echo "<td>";
				echo $scoreCriteria[$i]["crit"];
				echo "</td>";
				echo "<td>";
				echo $scoreCriteria[$i]["score"];
				echo "</td>";
				echo "</tr>";
			}
		?>
	</table>
	<br><br>
	<label for="score">Score:</label>
	<input type="text" name="score" id="score" <?php $scores=$database->getCurrentCommScore($_SESSION["ufid"],$_SESSION["student"],$_SESSION["item"]); echo "value=\"".$scores[0]."\""?>/>
	<input type="submit" name="submit" value="Submit Score"/>
	
	
</form>