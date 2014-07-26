<?php require_once("stuheader.php"); ?>
<?php require_once("header.php"); 

if($database->checkStudentAddMat($_SESSION["ufid"])==FALSE){
	$database->addUfidScholMat($_SESSION["ufid"]);
}

if(isset($_POST["continue"]) && $_POST["continue"]=="Save and Continue"){
	$database->updateStudentAddMat($_SESSION["ufid"],$_POST["essay"],$_POST["trans"],$_POST["resume"]);
	redirect("studentApp4.php");
}

$list=$database->getSavedAddMat($_SESSION["ufid"])
?>

<form action="studentApp2.php" method="POST"><p>
	<input type="submit" name="logout" value="Logout"/><br><br>
	<label for="essay">Type or copy your essay into the box below. Only include unformated text. 750 word maximum.</label><br>
	<textarea name="essay" id="essay" rows="20" cols="100">
<?php 
 			if($list["essay"]!=""){
 				echo $list["essay"];
 			}
		?>
</textarea><br><br>
<label for="trans">Copy your transcript into the box below. Only include unformated text.</label><br>
	<textarea name="trans" id="trans" rows="20" cols="100">
<?php 
 			if($list["transcript"]!=""){
 				echo $list["transcript"];
 			}
		?>
	</textarea> <br><br>
<label for="resume">Type or copy your resume into the box below. Only include unformated text. </label><br>
	<textarea name="resume" id="resume" rows="20" cols="100">
<?php 
 				if($list["resume"]!=""){
 					echo $list["resume"];
 				}
			?>
	</textarea><br><br>
<input type="submit" name="continue" value="Save and Continue"/> 
</p></form>

