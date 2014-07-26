<?php require_once("stuheader.php"); ?>
<?php require_once("header.php"); 
	
	$message = "";
	
	$list=$database->getStuAppData($_SESSION["ufid"]);
	
	//$refererz = $database->getStuRef($_SESSION["ufid"]);


	if(isset($_POST["continue"]) && $_POST["continue"]=="Save and Continue"){
		$database->setAppStart($_SESSION["ufid"]);
		$database->updateStudentApp($_SESSION["ufid"],$_POST["Name"],$_POST["LocalAdd"],$_POST["PermAdd"],$_POST["email"],$_POST["locPhone"],$_POST["PermPhone"],$_POST["COEStat"],$_POST["major"],$_POST["special"],$_POST["degree"],$_POST["grad"],$_POST["gpa"],$_POST["gre"]);
		redirect("studentApp2.php");
	}
// 	if(isset($_POST["addref1"])) {
// 		if(preg_match('/^(.+)@(.+\.[a-zA-Z]+)$/',$_POST["ref1mail"],$matches))
// 		{
// 			addref($_POST["ref1"],$_SESSION["ufid"],$_POST["ref1mail"],$_POST["ref1ori"]);
// 		}
// 		else $message="put an e-mail addr into it";
// 	}
// 	else if(isset($_POST["addref2"])) {
// 		if(preg_match('/^(.+)@(.+\.[a-zA-Z]+)$/',$_POST["ref2mail"],$matches))
// 		{
// 			addref($_POST["ref2"],$_SESSION["ufid"],$_POST["ref2mail"],$_POST["ref2ori"]);
// 		}
// 		else $message="put an e-mail addr into it";
// 		//echo $_POST["ref2ori"];
// 	}
?>
<form action="studentApp.php" method="POST">
	<input type="submit" name="logout" value="Logout">
</form>
<?php echo $message; ?>
<form action="studentApp.php" method="POST">
<p>
<label for="Name">Name (Last,First,MI):&nbsp;</label><input type="text" name="Name" id="Name"
	<?php 
		if($list["name"]!=""){
			echo "value=\"".$list["name"]."\"";
		}
	?>
/><br>
<label for="LocalAdd">Local Address:&nbsp;</label><input type="text" name="LocalAdd" id="LocalAdd"
	<?php 
		if($list["localAdd"]!=""){
			echo "value=\"".$list["localAdd"]."\"";
		}
	?>
/><br>
<label for="PermAdd">Permanent Address:&nbsp;</label><input type="text" name="PermAdd" id="PermAdd"
	<?php 
		if($list["permAdd"]!=""){
			echo "value=\"".$list["permAdd"]."\"";
		}
	?>
/><br>
<label for="email">E-mail Address:&nbsp;</label><input type="text" name="email" id="email"
	<?php 
		if($list["email"]!=""){
			echo "value=\"".$list["email"]."\"";
		}
	?>
/><br>
<label for="locPhone">Local Phone Number:&nbsp;</label><input type="text" name="locPhone" id="locPhone"
	<?php 
		if($list["localPhone"]!=""){
			echo "value=\"".$list["localPhone"]."\"";
		}
	?>
/><br>
<label for="PermPhone">Permanent Phone Number:&nbsp;</label><input type="text" name="PermPhone" id="PermPhone"
	<?php 
		if($list["permPhone"]!=""){
			echo "value=\"".$list["permPhone"]."\"";
		}
	?>
/><br>
<label for="coe">Are you a current COE student or Applicant to COE?</label>
<Select name="COEStat" id="coe">
	<option value=1 
		<?php 
			if($list["current"]==1){
				echo "selected=\"selected\"";
			}
		?>
	>Current</option>
	<option value=0
		<?php 
			if($list["current"]==0){
				echo "selected=\"selected\"";
			}
		?>
	>Applicant</option>
</Select><br>
<label for="major">Major in Fall 2013:&nbsp;</label>
<Select name="major" id="major">
	<option value="Marriage and Family Counseling"
		<?php 
			if($list["major"]=="Marriage and Family Counseling"){
				echo "selected=\"selected\"";
			}
		?>
	>Marriage and Family Counseling</option>
	<option value="Mental Health Counseling"
		<?php 
			if($list["major"]=="Mental Health Counseling"){
				echo "selected=\"selected\"";
			}
		?>
	>Mental Health Counseling</option>
	<option value="School Counseling and Guidance"
		<?php 
			if($list["major"]=="School Counseling and Guidance"){
				echo "selected=\"selected\"";
			}
		?>
	>School Counseling and Guidance</option>
	<option value="Counselor Education and Supervision"
		<?php 
			if($list["major"]=="Counselor Education and Supervision"){
				echo "selected=\"selected\"";
			}
		?>
	>Counselor Education and Supervision</option>
	<option value="Educational Leadership"
		<?php 
			if($list["major"]=="Educational Leadership"){
				echo "selected=\"selected\"";
			}
		?>
	>Educational Leadership</option>
	<option value="Higher Education Administration"
		<?php 
			if($list["major"]=="Higher Education Administration"){
				echo "selected=\"selected\"";
			}
		?>
	>Higher Education Administration</option>
	<option value="Student Personnel in Higher Education"
		<?php 
			if($list["major"]=="Student Personnel in Higher Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Student Personnel in Higher Education</option>
	<option value="Educational Technology"
		<?php 
			if($list["major"]=="Educational Technology"){
				echo "selected=\"selected\"";
			}
		?>
	>Educational Technology</option>
	<option value="Teacher Leadership for School Improvement"
		<?php 
			if($list["major"]=="Teacher Leadership for School Improvement"){
				echo "selected=\"selected\"";
			}
		?>
	>Teacher Leadership for School Improvement (TLSI)</option>
	<option value="Curriculum Teaching and Teacher Education"
		<?php 
			if($list["major"]=="Curriculum Teaching and Teacher Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Curriculum Teaching and Teacher Education (CTTE)</option>
	<option value="Elementry Education ProTeach"
		<?php 
			if($list["major"]=="Elementry Education ProTeach"){
				echo "selected=\"selected\"";
			}
		?>
	>Elementry Education - ProTeach</option>
	<option value="Elementry Education Traditional Masters"
		<?php 
			if($list["major"]=="Elementry Education Traditional Masters"){
				echo "selected=\"selected\"";
			}
		?>
	>Elementry Education - Traditional Masters</option>
	<option value="Mathematics Education"
		<?php 
			if($list["major"]=="Mathematics Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Mathematics Education</option>
	<option value="Science and Enviromental Education"
		<?php 
			if($list["major"]=="Science and Enviromental Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Science and Enviromental Education</option>
	<option value="Alternative Certification K6 M Ed Program"
		<?php 
			if($list["major"]=="Alternative Certification K6 M Ed Program"){
				echo "selected=\"selected\"";
			}
		?>
	>Alternative Certification K-6 M. Ed. Program (SITE)</option>
	<option value="Social Foundations of Education"
		<?php 
			if($list["major"]=="Social Foundations of Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Social Foundations of Education</option>
	<option value="Social Studies Education"
		<?php 
			if($list["major"]=="Social Studies Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Social Studies Education</option>
	<option value="English Education"
		<?php 
			if($list["major"]=="English Education"){
				echo "selected=\"selected\"";
			}
		?>
	>English Education</option>
	<option value="English Education Literacy and the Arts"
		<?php 
			if($list["major"]=="English Education Literacy and the Arts"){
				echo "selected=\"selected\"";
			}
		?>
	>English Education - Literacy and the Arts</option>
	<option value="English Education Media Literacy"
		<?php 
			if($list["major"]=="English Education Media Literacy"){
				echo "selected=\"selected\"";
			}
		?>
	>English Education - Media Literacy</option>
	<option value="ESOL"
		<?php 
			if($list["major"]=="ESOL"){
				echo "selected=\"selected\"";
			}
		?>
	>ESOL</option>
	<option value="Language Arts and Childrens Literature"
		<?php 
			if($list["major"]=="Language Arts and Childrens Literature"){
				echo "selected=\"selected\"";
			}
		?>
	>Language Arts and Children's Literature</option>
	<option value="Reading Education"
		<?php 
			if($list["major"]=="Reading Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Reading Education</option>
	<option value="Research Evaluation and Measurement Methodology"
		<?php 
			if($list["major"]=="Research Evaluation and Measurement Methodology"){
				echo "selected=\"selected\"";
			}
		?>
	>Research Evaluation and Measurement Methodology</option>
	<option value="School Psychology"
		<?php 
			if($list["major"]=="School Psychology"){
				echo "selected=\"selected\"";
			}
		?>
	>School Psychology</option>
	<option value="Early Childhood Education"
		<?php 
			if($list["major"]=="Early Childhood Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Early Childhood Education</option>
	<option value="Special Education"
		<?php 
			if($list["major"]=="Special Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Special Education</option>
</Select><br>
<label for="special">Specialization:&nbsp;</label>
<Select name="special" id="special">
	<option value="None">None</option>
	<option value="Bilingual ESOL Education"
		<?php 
			if($list["special"]=="Bilingual ESOL Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Bilingual/ESOL Education</option>
	<option value="Curriculum Teaching and Teacher Education"
		<?php 
			if($list["special"]=="Curriculum Teaching and Teacher Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Curriculum, Teaching and Teacher Education (CTTE)</option>
	<option value="Educational Technology"
		<?php 
			if($list["special"]=="Educational Technology"){
				echo "selected=\"selected\"";
			}
		?>
	>Educational Technology</option>
	<option value="English Education"
		<?php 
			if($list["special"]=="English Education"){
				echo "selected=\"selected\"";
			}
		?>
	>English Education</option>
	<option value="English Education Literacy and the Arts"
		<?php 
			if($list["special"]=="English Education Literacy and the Arts"){
				echo "selected=\"selected\"";
			}
		?>
	>English Education - Literacy and the Arts</option>
	<option value="English Education Media Literacy"
		<?php 
			if($list["special"]=="English Education Media Literacy"){
				echo "selected=\"selected\"";
			}
		?>
	>English Education - Media Literacy</option>
	<option value="Language Arts and Childrens Literature"
		<?php 
			if($list["special"]=="Language Arts and Childrens Literature"){
				echo "selected=\"selected\"";
			}
		?>
	>Language Arts and Children's Literature</option>
	<option value="Mathematics Education"
		<?php 
			if($list["special"]=="Mathematics Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Mathematics Education</option>
	<option value="Reading Education"
		<?php 
			if($list["special"]=="Reading Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Reading Education</option>
	<option value="Teacher Leadership for School Improvement"
		<?php 
			if($list["special"]=="Teacher Leadership for School Improvement"){
				echo "selected=\"selected\"";
			}
		?>
	>Teacher Leadership for School Improvement (TLSI)</option>
	<option value="Science and Enviromental Education"
		<?php 
			if($list["special"]=="Science and Enviromental Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Science and Enviromental Education</option>
	<option value="Social Studies Education"
		<?php 
			if($list["special"]=="Social Studies Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Social Studies Education</option>
	<option value="Early Childhood Education"
		<?php 
			if($list["special"]=="Early Childhood Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Early Childhood Education</option>
	<option value="Educational Leadership"
		<?php 
			if($list["special"]=="Educational Leadership"){
				echo "selected=\"selected\"";
			}
		?>
	>Educational Leadership</option>
	<option value="Higher Education Administration"
		<?php 
			if($list["special"]=="Higher Education Administration"){
				echo "selected=\"selected\"";
			}
		?>
	>Higher Education Administration</option>
	<option value="Marriage and Family Counseling"
		<?php 
			if($list["special"]=="Marriage and Family Counseling"){
				echo "selected=\"selected\"";
			}
		?>
	>Marriage and Family Counseling</option>
	<option value="Mental Health Counseling"
		<?php 
			if($list["special"]=="Mental Health Counseling"){
				echo "selected=\"selected\"";
			}
		?>
	>Mental Health Counseling</option>
	<option value="School Counseling and Guidance"
		<?php 
			if($list["special"]=="School Counseling and Guidance"){
				echo "selected=\"selected\"";
			}
		?>
	>School Counseling and Guidance</option>
	<option value="School Psychology"
		<?php 
			if($list["special"]=="School Psychology"){
				echo "selected=\"selected\"";
			}
		?>
	>School Psychology</option>
	<option value="Special Education"
		<?php 
			if($list["special"]=="Special Education"){
				echo "selected=\"selected\"";
			}
		?>
	>Special Education</option>
</Select><br>
<label for="degree">Degree seeking in Fall 2013:&nbsp;</label>
<select name="degree" id="degree">
	<option value="BAE"
		<?php 
			if($list["degree"]=="BAE"){
				echo "selected=\"selected\"";
			}
		?>
	>BAE</option>
	<option value="MAE"
		<?php 
			if($list["degree"]=="MAE"){
				echo "selected=\"selected\"";
			}
		?>
	>MAE</option>
	<option value="MED"
		<?php 
			if($list["degree"]=="MED"){
				echo "selected=\"selected\"";
			}
		?>
	>MED</option>
	<option value="EDS"
		<?php 
			if($list["degree"]=="EDS"){
				echo "selected=\"selected\"";
			}
		?>
	>EDS</option>
	<option value="EDD"
		<?php 
			if($list["degree"]=="EDD"){
				echo "selected=\"selected\"";
			}
		?>
	>EDD</option>
	<option value="PHD"
		<?php 
			if($list["degree"]=="PHD"){
				echo "selected=\"selected\"";
			}
		?>
	>PHD</option>
</select><br>
<label for="grad">Anticipated Graduaton Date:</label>
<input type="text" name="grad" id="grad"
	<?php 
		if($list["grad"]!=""){
			echo "value=\"".$list["grad"]."\"";
		}
	?>
/><br>
<label for="gpa">Current GPA: </label><input type="text" name="gpa" id="gpa"
	<?php 
		if($list["gpa"]!=""){
			echo "value=\"".$list["gpa"]."\"";
		}
	?>
/><br>
<label for="gre">GRE, SAT or ACT score: </label><input type="text" name="gre" id="gre"
	<?php 
		if($list["gre"]!=""){
			echo "value=\"".$list["gre"]."\"";
		}
	?>
/><br>
<input type="submit" name="continue" value="Save and Continue"/>
<!-- <input type="submit" name="submit" value="submit" /> -->
<!-- 	<br/> -->
<!-- 	refercener 1 : <input type="text" name="ref1"  -->
	<?php //if(isset($refererz[0])) echo "value='".$refererz[0]."'" ?> 
<!-- 	/> -->
<!-- 	E-mail address : <input type="text" name="ref1mail"   /> -->
<!-- 	<input type="hidden" name="ref1ori"  -->
	<?php // if(isset($refererz[0])) echo "value='".$refererz[0]."'" ?> 
<!-- 	/> -->
<!-- 	<input type="submit" name="addref1" value="update referencer 1" /> -->
<!-- 	<br/> -->
<!-- 	refercener 2:  -->
<!-- 	<input type="text" name="ref2"  -->
	<?php //if(isset($refererz[1])) echo "value='".$refererz[1]."'" ?>  
<!-- 	/> -->
<!-- 	E-mail address : <input type="text" name="ref2mail"  /> -->
<!-- 	<input type="hidden" name="ref2ori"  -->
	<?php //if(isset($refererz[1])) echo "value='".$refererz[1]."'" ?> 
<!-- 	/> -->
<!-- 	<input type="submit" name="addref2" value="update referencer 2" /> -->
</p>
</form>
</body>
</html>




