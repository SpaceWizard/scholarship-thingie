<?php require_once("refererheader.php"); ?>
<?php require_once("header.php"); 
	if(isset($_POST["submit"]) && !empty($_POST["submit"])){		
		foreach ($_POST as $key=>$value){
			if($key!="submit"){
				$database->removeReference($_SESSION["ufid"],$_SESSION["student"],$key);
				$database->recordReference($_SESSION["ufid"],$_SESSION["student"],$key,$value);				
			}
		}
		$database->completedReference($_SESSION["ufid"], $_SESSION["student"]);
		redirect("mane.php");
	}
?>
<form action="recommendation.php" method="POST">
	<input type="submit" name="logout" value="Logout">

<p>Please fill out the recommendation from below for <?php $name=$database->getStudentName($_SESSION["student"]); echo $name[0];?>.</p>
<p>Please evaluate in the context of the applicant's ability as a student and potential to succeed in his or her chosen field, compared with other students at the same academic level.</p>
<table border="1">
	<tr>
    	<th>Candidate Evaluation</th>
    	<th>Exceptional (4)</th>
    	<th>Above Average (3)</th>
    	<th>Average (2)</th>
    	<th>Below Average (1)</th>
    	<th>Unknown</th>
  	</tr>
  	<tr>
    	<td>Commitment to professional growth/development</td>
    	<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "growth");?>
    	<td><input type="radio" name="growth" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="growth" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="growth" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="growth" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="growth" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
  	</tr>
	<tr>
   		<td>Competence in chosen field</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "competence");?>
    	<td><input type="radio" name="competence" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="competence" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="competence" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="competence" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="competence" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
  	</tr>
  	<tr>
   		<td>Motivation/Initiative</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "motivation");?>
    	<td><input type="radio" name="motivation" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="motivation" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="motivation" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="motivation" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="motivation" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Academic Performance</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "academic");?>
    	<td><input type="radio" name="academic" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="academic" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="academic" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="academic" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="academic" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Intellectual ability/critical thinking skills</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "intellectual");?>
    	<td><input type="radio" name="intellectual" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="intellectual" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="intellectual" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="intellectual" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="intellectual" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Potential as a professional in chosen field</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "potential");?>
    	<td><input type="radio" name="potential" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="potential" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="potential" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="potential" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="potential" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Leadership</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "leadership");?>
    	<td><input type="radio" name="leadership" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="leadership" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="leadership" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="leadership" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="leadership" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Quality of work</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "quality");?>
    	<td><input type="radio" name="quality" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="quality" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="quality" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="quality" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="quality" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Emotional maturity</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "maturity");?>
    	<td><input type="radio" name="maturity" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="maturity" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="maturity" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="maturity" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="maturity" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Research aptitude/potential</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "research");?>
    	<td><input type="radio" name="research" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="research" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="research" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="research" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="research" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Written communication shills</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "written");?>
    	<td><input type="radio" name="written" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="written" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="written" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="written" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="written" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Oral communication skills</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "oral");?>
    	<td><input type="radio" name="oral" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="oral" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="oral" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="oral" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="oral" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Attention to important details</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "attention");?>
    	<td><input type="radio" name="attention" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="attention" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="attention" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="attention" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="attention" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Creativity/innovation</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "creativity");?>
    	<td><input type="radio" name="creativity" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="creativity" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="creativity" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="creativity" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="creativity" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Enthusiasm for learning, teaching, and/or research</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "enthusiasm");?>
    	<td><input type="radio" name="enthusiasm" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="enthusiasm" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="enthusiasm" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="enthusiasm" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="enthusiasm" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Volunteerism</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "volunteerism");?>
    	<td><input type="radio" name="volunteerism" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="volunteerism" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="volunteerism" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="volunteerism" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="volunteerism" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 	<tr>
   		<td>Dependability/reliability</td>
   		<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "dependability");?>
    	<td><input type="radio" name="dependability" value="Exceptional" <?php if($list[0]=="Exceptional"){echo "checked";}?>/></td>
    	<td><input type="radio" name="dependability" value="Above Average" <?php if($list[0]=="Above Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="dependability" value="Average" <?php if($list[0]=="Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="dependability" value="Below Average" <?php if($list[0]=="Below Average"){echo "checked";}?>/></td>
    	<td><input type="radio" name="dependability" value="Unknown" <?php if($list[0]=="Unknown"){echo "checked";}?>/></td>
 	</tr>
 </table><br>
 Overall Evaluation: Compared with a representative group of students at the same academic level, I would rank this student's GENERAL ALL-AROUND ABILITY in the top:
 <table>
 	<tr>
 	<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "overall");?>	
    	<td><input type="radio" name="overall" value="1" <?php if($list[0]=="1"){echo "checked";}?>/>1%</td>
    	<td><input type="radio" name="overall" value="5" <?php if($list[0]=="5"){echo "checked";}?>/>5%</td>
    	<td><input type="radio" name="overall" value="10" <?php if($list[0]=="10"){echo "checked";}?>/>10%</td>
    	<td><input type="radio" name="overall" value="25" <?php if($list[0]=="25"){echo "checked";}?>/>25%</td>
    	<td><input type="radio" name="overall" value="50" <?php if($list[0]=="50"){echo "checked";}?>/>50%</td>
    	<td><input type="radio" name="overall" value="lower 50" <?php if($list[0]=="lower 50"){echo "checked";}?>/>lower 50%</td>
 	</tr>
</table><br>
<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "length");?>
How long have you known the candidate? <input type="text" name="length" size="70" <?php echo "value=\"".$list[0]."\"";?>/><br><br>
<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "capacity");?>
In what capacity do you know the candidate? <input type="text" name="capacity" size="70" <?php echo "value=\"".$list[0]."\"";?>/><br><br>
<?php $list=$database->getReferenceData($_SESSION["ufid"], $_SESSION["student"], "comments");?>
Please feel free to provide further specific comments and other consideration (you do not have to insert a reference letter):
<textarea name="comments" id="essay" rows="20" cols="90">
<?php echo $list[0];?>
</textarea><br><br>
<input type="submit" name="submit" value="Submit Reference"/>
</form>
<?php
$database->disconnect();
?>


</body>
</html>