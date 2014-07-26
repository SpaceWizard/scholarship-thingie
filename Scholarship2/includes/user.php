<?php
//namespace scholarship;
require_once("init.php");

class user {
public $ufid = NULL;
public $password = NULL;
public $message = NULL;
// use gauss as user class, "class" iz already taken
public $gauss = NULL;

function confirm() {
	global $database;
	$result = $database->autenticate($this->ufid,$this->password);
	if(isset($result)) {
		return $result;
	}
	else {
		return FALSE;
	}
}

}
?>