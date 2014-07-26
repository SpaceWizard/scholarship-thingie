<?php 
	require_once("stuheader.php"); 
	require_once("header.php");
	
	

	

	if(isset($_POST["addref1"])) {
		if(preg_match('/^(.+)@(.+\.[a-zA-Z]+)$/',$_POST["ref1mail"],$matches)){
			addref($_POST["ref1"],$_SESSION["ufid"],$_POST["ref1mail"],$_POST["ref1ori"]);
		}else{ 
			$message="This is not a valid email address";
		}
	}else if(isset($_POST["addref2"])) {
		if(preg_match('/^(.+)@(.+\.[a-zA-Z]+)$/',$_POST["ref2mail"],$matches)){
			addref($_POST["ref2"],$_SESSION["ufid"],$_POST["ref2mail"],$_POST["ref2ori"]);
		}else{ 
			$message="That is not a valid email address";
		}
		//echo $_POST["ref2ori"];
	}
	
	/*if(isset($_POST["continue"]) && $_POST["continue"]=="Save and Continue"){
		$checkRef1=$database->checkReferExist($_POST["ref1mail"]);
		$checkRef2=$database->checkReferExist($_POST["ref2mail"]);
		$database->clearReferences($_SESSION["ufid"]);
		if($checkRef1==FALSE){			
			$username=str_replace(" ","",$_POST["ref1"]);
			$database->addReferrer($username,$_POST["ref1"],$_POST["ref1mail"]);
			$database-> addStudentReferer($_SESSION["ufid"],$username);
		}else{
			$database-> addStudentReferer($_SESSION["ufid"],$checkRef1);
		}
		if($checkRef2==FALSE){
			$username=str_replace(" ","",$_POST["ref2"]);
			$database->addReferrer($username,$_POST["ref2"],$_POST["ref2mail"]);
			$database-> addStudentReferer($_SESSION["ufid"],$username);
		}else{
			$database-> addStudentReferer($_SESSION["ufid"],$checkRef2);
		}
		redirect("studentApp3.php");
	}*/
	
	$refererz = $database->getStuRef($_SESSION["ufid"]);
?>
<form action="studentApp4.php" method="POST"><p>
	<input type="submit" name="logout" value="Logout"/><br><br>
<p>Please enter below the name and email address of your references. When you hit Send Email an email will automatically be sent to your reference asking them to fill out the reference sheet. Once you are finished click save and continue. You can save and continue without sending the emails and can come back later to send them.</p> 
<!-- 	<br/> -->
	Reference 1 : <input type="text" name="ref1" <?php if(isset($refererz[0])) echo "value='".$refererz[0]["name"]."'" ?> />
	E-mail address : <input type="text" name="ref1mail" <?php if(isset($refererz[0])) echo "value='".$refererz[0]["email"]."'" ?>/>
	<input type="hidden" name="ref1ori" <?php  if(isset($refererz[0])) echo "value='".$refererz[0]["ufid"]."'" ?> />
	<input type="submit" name="addref1" value="Send Email" />
	<br/>
	Reference 2: <input type="text" name="ref2" <?php if(isset($refererz[1])) echo "value='".$refererz[1]["name"]."'" ?>  />
	E-mail address : <input type="text" name="ref2mail" <?php if(isset($refererz[1])) echo "value='".$refererz[1]["email"]."'" ?> />
	<input type="hidden" name="ref2ori" <?php if(isset($refererz[1])) echo "value='".$refererz[1]["ufid"]."'" ?> />
	<input type="submit" name="addref2" value="Send Email" /><br><br>
	
	<input type="submit" name="continue" value="Save and Continue"/> 
	</form>