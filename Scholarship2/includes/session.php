<?php
//namespace scholarship;

class session {
//private $loggedin = FALSE;
private $ufid = NULL;
//gauss stores uzer class!
//private $gauss = NULL;

function __construct() {
	session_start();
	session_set_cookie_params(3600);
}

function login ($user,$password){
	global $database;
	//$password = egencrypt($password);
	$result = $database->autenticate($user,$password);

	if($result!=FALSE) {
		$_SESSION["ufid"] = $user;
		
		return $result;
	}
	else {
		return FALSE;
	}

	/*if($user) {
		$_SESSION["ufid"] = $user->ufid;
		return TRUE;
	}*/
}

function logout () {
	unset($_SESSION["ufid"]);
	$this->killsession();
	return TRUE;
}

private function killsession() {
	session_destroy();
	session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
}

function checklogin($userclass) {
	global $database;
	$gauss = NULL;
	if(isset($_SESSION["ufid"])) {
		// gauss iz the class of teh uzer
		$gauss = $database->get_user_class($_SESSION["ufid"]);
		if(isset($gauss)&&$gauss==$userclass) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	else {
		return FALSE; 
	}
}

}

$session= new session();

?>
