<?php require_once("adminheader.php"); ?> 
<?php require_once("header.php"); 

If(isset($_POST['add']) && $_POST['add']=="Add Scholarship"){
	$database->add_scholarship($_POST["name"],$_POST["quantity"],$_POST["amount"],$_POST["deadline"]);
	$_SESSION["scholarship"] = $_POST["name"];
	redirect("scholarshipedit.php");
}

?>

<form action="addscholarship.php" method="POST"><p>
	<label for="name" >Scholarship Name: &nbsp;</label><input type="text" name="name" id="name"/><br><br>
	<label for="quantity" >Quantity: &nbsp;</label><input type="text" name="quantity" id="quantity"/><br><br>
	<label for="amount" >Award Amount: &nbsp;</label><input type="text" name="amount" id="amount"/><br><br>
	<label for="deadline" >Deadline: &nbsp;</label><input type="text" name="deadline" id="deadline"/><br><br>
	<input type="submit" name="add" value="Add Scholarship"/><br><br>

	<a href="scholarship.php">Return to Scholarship Page</a>
	
</p></form>
