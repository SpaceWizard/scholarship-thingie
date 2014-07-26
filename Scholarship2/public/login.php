
<?php require_once("../includes/init.php"); ?>
<?php 
if($database->checkBan($_SERVER['REMOTE_ADDR'])>=3) {
	die("you've been banned, please contact tech support to lift the ban");
}
$message = "Please login to apply for or review scholarship applications.";
$userclasses = array("admin","committee");
foreach($userclasses as $userclass) {
	if($session->checklogin($userclass)){
		redirect($userclass."/mane.php");
	}
}
if(isset($_POST["login"])) {
	$confirm = $session->login($_POST["ufid"],$_POST["password"]);
	if($confirm){		
		redirect($confirm."/mane.php");
	}
	else {
		$database->addBan($_SERVER['REMOTE_ADDR']);
		$message = "Sorry the login failed. Please try again!";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <link  href="../includes/style.css" rel="stylesheet" type="text/css" />
<title>College of Education Scholarships</title>
</head>
<body>
<h1>College of Education Scholarships</h1>
<p> Welcome to the College of Education Scholarship homepage. <br> 
	
<?php echo $message;?>

</p>
<hr>

<form action="login.php" method="POST">
	<p>
	<label for="ufid" >Username: &nbsp;</label><input type="text" name="ufid" id="ufid"/><br><br>
	<label for="password">Password:&nbsp;</label><input type="password" name="password" id="password"/>
	<br/>
	<input type="submit" name="login" value="Login">
	</p>
</form>

<?php
$database->disconnect();
?>
</body>
</html>