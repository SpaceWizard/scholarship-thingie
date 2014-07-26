<?php
//namespace scholarship;
require_once("init.php");

class database {
private $connection = NULL;
private $stmt = NULL;
//private $table = "users";
static $debug = TRUE;

function __construct() {
	$this->connect();
}

private function connect() {
	$this->connection = new \mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	if ((!$this->connection)&&self::$debug) {
		die("connection lost: ".$this->connection->connect_error);
	}
}

function disconnect() {
	if((!$this->connection)&&self::$debug) {
		die("no connection");
	}
	if(isset($this->stmt)) {
		$this->stmt->free_result();
		$this->stmt->close();
	}
	$this->connection->close();
}

function autenticate($ufid,$password) {
	$ufid = $this->purgeinput($ufid);
	if(!$this->checkexist(array($ufid),array("ufid"),"users")) {
		return FALSE;
	}
	$password = $this->purgeinput($password);
	$this->stmt = $this->connection->prepare("
		SELECT password,iv,class
		FROM users
		WHERE ufid=?
		LIMIT 1
	");
	$this->stmt->bind_param("s",$ufid);
	
	if((!$this->stmt)&&self::$debug) {
		die("preparation failed".$this->connection->error);
	}
// use gauss as user class, "class" iz already taken
	$gauss = NULL;
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($ivpassword,$iv,$gauss);
	while($this->stmt->fetch()) {
		null;
	}
	$actualpass = aesdecrypt($ivpassword,$iv);
//some creepy "\u0000\u0000\u0000\u0000\u0000\u0000\u0000\u0000\u0000\u0000" stalks the decrypted password, i'll just do some black magic
	$actualpass = json_encode($actualpass);
	if(strstr($actualpass,"\u",true)){
		//die(json_encode($password));
		$actualpass = strstr($actualpass,"\u",true);
		$actualpass = substr($actualpass,1);
	}
	else {
		$actualpass = substr($actualpass,0,-1);
		$actualpass = substr($actualpass,1);
	}
	//$actualpass = substr($actualpass, 0, strlen($password));
	if($actualpass == $password) {
		return purgeoutput($gauss);
	}
	else {
		//die(json_encode($actualpass).json_encode($password));
		return FALSE;
	}
}

function getpassword($ufid) {
	$colum = $this->purgeinput($ufid);
	$this->stmt = $this->connection->prepare("
		SELECT password,iv
		FROM users
		WHERE ufid = ?
		LIMIT 1
	");
	$this->stmt->bind_param("s",$ufid);
	if((!$this->stmt)&&self::$debug) {
		die(" SELECT password,iv FROM users WHERE ufid = '".$ufid."' LIMIT 1 ");
	}
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($ivpassword,$iv);
	$this->stmt->fetch();
	//die(utf8_encode($ivpassword));
	$password = aesdecrypt($ivpassword,$iv);
	//die($password);
	$password = json_encode($password);
	//die($password);
	if(strstr($password,"\u",true)){
		//die(json_encode($password));
		$password = strstr($password,"\u",true);
		$password = substr($password,1);
	}
	else {
		$password = substr($password,0,-1);
		$password = substr($password,1);
	}
	//die(json_encode($password));
	if(isset($password)) {
		return purgeoutput($password);
	}
	else {
		return FALSE;
	}
}

function get_user_class($user) {
	$this->stmt = $this->connection->prepare("
		SELECT class
		FROM users
		WHERE ufid = ?
		LIMIT 1
	");
	//die(" SELECT ".$colum." FROM ".$table." WHERE ".$pk." = ? LIMIT 1 ");
	$this->stmt->bind_param("s",$user);
	$user_class = NULL;
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($user_class);
	$this->stmt->fetch();
	//$this->disconnect();
	if(isset($user_class)) {
		return purgeoutput($user_class);
	}
	else {
		return FALSE;
	}
}

function get_users() {
	$this->stmt = $this->connection->prepare("
		SELECT ufid,class
		FROM users
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($ufid,$class);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["ufid"] = $ufid;
		$result[$i]["class"] = $class;
	}
	//die(json_encode($result));
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function get_committee() {
	$this->stmt = $this->connection->prepare("
		SELECT ufid
		FROM users
		WHERE class='committee'
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($ufid);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i] = $ufid;
	}
	//die(json_encode($result));
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function insertuser($ufid,$class,$password) {
	$ufid = $this->purgeinput($ufid);
	$class = $this->purgeinput($class);
	$password = $this->purgeinput($password);
	$password_return = aesencrypt($password);
	$this->stmt = $this->connection->prepare("
		INSERT INTO users (ufid, class, password, iv)
		VALUES (? , ? , ? , ?)
	");
	$this->stmt->bind_param("ssss",$ufid,$class,$password_return["password"],$password_return["iv"]);
	if(!$this->stmt) die("preparation failed");
	//$this->
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}	
}

function deleteuser($user) {
	$this->stmt = $this->connection->prepare("
		DELETE 
		FROM users
		WHERE ufid=?
	");
	$this->stmt->bind_param("s",$user);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function check_com_stu_exist($committee,$student) {
	$this->stmt = $this->connection->prepare("
		SELECT committee
		FROM com_stu
		WHERE committee=? 
		AND student=?
		LIMIT 1
	");
	if((!$this->stmt)&&self::$debug) {
		die("preparation failed".$this->connection->error);
	}
	$this->stmt->bind_param("ss",$committee,$student);
	$this->stmt->execute();
	$this->stmt->store_result();
	$result = array();
	$this->stmt->bind_result($result);
	$this->stmt->fetch();
	if(isset($result)) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function check_com_stu_score_exist($committee,$student,$title) {
	$this->stmt = $this->connection->prepare("
		SELECT committee
		FROM com_stu_score
		WHERE committee=? 
		AND student=?
		AND title=?
		LIMIT 1
	");
	if((!$this->stmt)&&self::$debug) {
		die("preparation failed".$this->connection->error);
	}
	$this->stmt->bind_param("sss",$committee,$student,$title);
	$this->stmt->execute();
	$this->stmt->store_result();
	$result = array();
	$this->stmt->bind_result($result);
	$this->stmt->fetch();
	if(isset($result)) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function check_com_stu_score_exist2($committee,$student,$title,$score) {
	$this->stmt = $this->connection->prepare("
		SELECT committee
		FROM com_stu_score
		WHERE committee=? 
		AND student=?
		AND title=?
		AND score=?
		LIMIT 1
	");
	if((!$this->stmt)&&self::$debug) {
		die("preparation failed".$this->connection->error);
	}
	$this->stmt->bind_param("ssss",$committee,$student,$title,$score);
	$this->stmt->execute();
	$this->stmt->store_result();
	$result = array();
	$this->stmt->bind_result($result);
	$this->stmt->fetch();
	if(isset($result)) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function list_com_stu_chosen($committee) {
	$this->stmt = $this->connection->prepare("
		SELECT student
		FROM com_stu
		WHERE committee=? 
	");
	$this->stmt->bind_param("s",$committee);
	$this->stmt->execute();
	$this->stmt->store_result();
	$chosen = array();
	$this->stmt->bind_result($result);
	while($this->stmt->fetch()) {
		$chosen[] = $result;
	}
	if(count($chosen) != 0) {
		return $chosen;
	}
	else {
		return FALSE;
	}
}

function list_stu() {
	$this->stmt = $this->connection->prepare("
		SELECT ufid
		FROM students
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$not_chosen = array();
	$this->stmt->bind_result($result);
	while($this->stmt->fetch()) {
		$not_chosen[] = $result;
	}
	if(count($not_chosen) != 0) {
		return $not_chosen;
	}
	else {
		return FALSE;
	}
}

function insert_com_stu($committee,$student) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO com_stu (committee,student)
		VALUES (? , ? )
	");
	$this->stmt->bind_param("ss",$committee,$student);
	if(!$this->stmt) die("preparation failed");
	//$this->
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function insert_com_stu_score($committee,$student,$title,$score) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO com_stu_score (committee,student,title,score)
		VALUES (?, ?, ?, ? )
	");
	$this->stmt->bind_param("ssss",$committee,$student,$title,$score);
	if(!$this->stmt) die("preparation failed");
	//$this->
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function delete_com_stu($committee,$student) {
	$this->stmt = $this->connection->prepare("
		DELETE 
		FROM com_stu
		WHERE committee=?
		AND student=?
	");
	$this->stmt->bind_param("ss",$committee,$student);
	if(!$this->stmt) die("preparation failed");
	//$this->
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function get_com_score(){
	$this->stmt = $this->connection->prepare("
		SELECT title,score,comment
		FROM com_score
		ORDER BY title,score DESC
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($title,$score,$comment);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["title"] = $title;
		$result[$i]["score"] = $score;
		$result[$i]["comment"] = $comment;
	}
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function update_com_stu_score($committee,$student,$title,$score) {
	$this->stmt = $this->connection->prepare("
		UPDATE com_stu_score
		SET score=?
		WHERE committee=?
		AND student=?
		AND title=?
	");
	$this->stmt->bind_param("ssss",$score,$committee,$student,$title);
	if(!$this->stmt) die("preparation failed");
	//$this->
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

/**********************************************************************************************************************************
twinkle twinkle little star
************************************************************************************************************************************/
function checkexist($vars,$columns,$table) {
	//$this->connect();
	$table = $this->purgeinput($table);
	$constraint = $this->complexarray2string($columns,$vars," = "," AND ");
	$this->stmt = $this->connection->prepare("
		SELECT ".$columns[0]."
		FROM ".$table."
		WHERE ".$constraint."
		LIMIT 1
	");
	if((!$this->stmt)&&self::$debug) {
		die("preparation failed".$this->connection->error);
	}
	$this->stmt->execute();
	$this->stmt->store_result();
	$result = array();
	$this->stmt->bind_result($result);
	while($this->stmt->fetch()) {
		$result1 = $result;
		null;
	}
	//$this->disconnect();
	if(isset($result1)) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function getcolum($colum,$table,$primary,$values = NULL) {
	//$this->connect();
	$colum = $this->purgeinput($colum);
	$table = $this->purgeinput($table);
	$pk = $this->array2string($primary);
	if(!isset($values)){
		$this->stmt = $this->connection->prepare("
			SELECT ".$colum."
			FROM ".$table."
			ORDER BY ".$pk." DESC
		");
		//die(" SELECT ".$colum." FROM ".$table." ORDER BY ".$pk." DESC ");
	}
	else {
		$constraint = $this->complexarray2string($primary,$values," = "," AND ");
		$this->stmt = $this->connection->prepare("
			SELECT ".$colum."
			FROM ".$table."
			WHERE ".$constraint."
		");
		//die("SELECT ".$colum." FROM ".$table." WHERE ".$constraint." ");
	}
	if(!$this->stmt) die("pp failed");
	$result = array();
	$component = NULL;
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($component);
	while($this->stmt->fetch()) {
		$result[] = purgeoutput($component);
	}
	//$this->disconnect();
	if(isset($result)) {
		return $result;
	}
	else {
		return FALSE;
	}
}



/*function getelementfromrow($colum,$row,$table,$pk) {
	//$this->connect();
	//sanitize input
	$colum = $this->purgeinput($colum);
	$row = $this->purgeinput($row);
	$table = $this->purgeinput($table);
	$pk = $this->purgeinput($pk);
	//$pk = $this->array2string($pk);
	$this->stmt = $this->connection->prepare("
		SELECT ?
		FROM ?
		WHERE ? = ?
		LIMIT 1
	");
	
	//die(" SELECT ".$colum." FROM ".$table." WHERE ".$pk." = ? LIMIT 1 ");
	$this->stmt->bind_param("ssss",$colum,$table,$pk,$row);
	$yaranaika = NULL;
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($yaranaika);
	$this->stmt->fetch();
	//$this->disconnect();
	if(isset($yaranaika)) {
		return purgeoutput($yaranaika);
	}
	else {
		return FALSE;
	}
}

function getpassword($ufid) {
	$colum = $this->purgeinput($ufid);
	$this->stmt = $this->connection->prepare("
		SELECT password,iv
		FROM users
		WHERE ufid = ?
		LIMIT 1
	");
	$this->stmt->bind_param("s",$ufid);
	if((!$this->stmt)&&self::$debug) {
		die(" SELECT password,iv FROM users WHERE ufid = '".$ufid."' LIMIT 1 ");
	}
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($ivpassword,$iv);
	$this->stmt->fetch();
	//die(utf8_encode($ivpassword));
	$password = aesdecrypt($ivpassword,$iv);
	//die($password);
	$password = json_encode($password);
	//die($password);
	if(strstr($password,"\u",true)){
		//die(json_encode($password));
		$password = strstr($password,"\u",true);
		$password = substr($password,1);
	}
	else {
		$password = substr($password,0,-1);
		$password = substr($password,1);
	}
	//die(json_encode($password));
	if(isset($password)) {
		return purgeoutput($password);
	}
	else {
		return FALSE;
	}
}*/

function geteverything($colums,$table,$pk, $values = NULL) {
	$result = array();
	foreach($colums as $colum) {
		if(isset($values)){
			$result[] = $this->getcolum($colum,$table,$pk,$values);
		}
		else $result[] = $this->getcolum($colum,$table,$pk);
	}
	if(isset($result)) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function deletrows($pks,$keys,$table) {
	//$this->connect();
	$constraint = $this->complexarray2string($pks,$keys," = "," AND ");
	$table = $this->purgeinput($table);
	$this->stmt = $this->connection->prepare("
		DELETE FROM ".$table."
		WHERE ".$constraint."
	");
	//die($constraint);
	//$this->stmt->bind_param("s",$key);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		//$this->disconnect();
		return TRUE;
	}
	else {
		//$this->disconnect();
		return FALSE;
	}
}

function updatecolum($key,$value,$table,$colum,$pk) {
	//$this->connect();
	$key = $this->purgeinput($key);
	$value = $this->purgeinput($value);
	$table = $this->purgeinput($table);
	$colum = $this->purgeinput($colum);
	$pk = $this->purgeinput($pk);
//	$pk = $this->array2string($pk);
	$this->stmt = $this->connection->prepare("
		UPDATE ?
		SET ? = ?
		WHERE ? = ?
		LIMIT 1
	");
	$this->stmt->bind_param("sssss",$table,$colum,$pk,$value,$key);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		//$this->disconnect();
		return TRUE;
	}
	else {
		//$this->disconnect();
		return FALSE;
	}
}

function massupdate($table,$colums,$values,$pk,$keys) {
	//$this->connect();
	$table = $this->purgeinput($table);
	$valueset = $this->complexarray2string($colums,$values," = ",", ");
	$keymatch = $this->complexarray2string($pk,$keys," = "," AND ");
	$this->stmt = $this->connection->prepare("
		UPDATE ".$table."
		SET ".$valueset."
		WHERE ".$keymatch."
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		//$this->disconnect();
		return TRUE;
	}
	else {
		//$this->disconnect();
		return FALSE;
	}
}


function insertrow($values,$table,$columns) {
	//$this->connect();
	$dbcolumn = NULL;
	$dbvalue = NULL;
	$lastvalue = "'".array_pop($values)."'";
	foreach ($values as $value) {
		$value = $this->purgeinput($value);
		$dbvalue .= "'".$value."'";
		$dbvalue .= ", ";
	}
	$dbcolumn = $this->array2string($columns);
//	die($dbcolumn);
	$table = $this->purgeinput($table);
	$this->stmt = $this->connection->prepare("
		INSERT INTO ".$table." (".$dbcolumn.")
		VALUES (".$dbvalue.$lastvalue.")
	");
	if(!$this->stmt) die("preparation failed");
//	$this->stmt->bind_param($dbvaluecounts,implode(","$values));
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		//$this->disconnect();
		return TRUE;
	}
	else {
		//$this->disconnect();
		return FALSE;
	}	
}

//encryted strings are such WINRARs


function list4select($connecttable,$ppk,$cpk,$user,$selecttable,$pk) {
	$p_c = $this->getcolum($cpk,$connecttable,$ppk);
	$p_p = $this->getcolum($ppk,$connecttable,$ppk);
	$s = $this->getcolum($pk,$selecttable,$pk);
	$chosen_of_tzeentch = array();
	foreach($p_p as $key => $value) {
		if($value == $user) {
			$chosen_of_tzeentch[$key] = $p_c[$key];
		}
	}
	$not_chosen = array_diff($s,$chosen_of_tzeentch);
	$returnarray = array($chosen_of_tzeentch,$not_chosen);
	//print_r($returnarray);
	return $returnarray;
}

function row_num($table) {
	$row_num = NULL;
	//$this->connect();
	$table = $this->purgeinput($table);
	$this->stmt = $this->connection->prepare("
		SELECT *
		FROM ".$table."
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$row_num = $this->stmt->num_rows();
	//$this->disconnect();
	if(isset($row_num)) {
		return $row_num;
	}
	else {
		return FALSE;
	}
}

function match($arr1,$arr2,$b1,$b2) {
	$result = NULL;
	$lastarr1 = array_pop($arr1);
	$lastarr2 = array_pop($arr2);
	foreach($arr1 as $key => $value) {
		$result .= $this->purgeinput($arr1[$key]).$b1."'".$this->purgeinput($arr2[$key])."'".$b2;
	}
	$result .= $this->purgeinput($lastarr1).$b1."'".$this->purgeinput($lastarr2)."'";
	return $result;
}

function complexarray2string($arr1,$arr2,$b1,$b2) {
$result = NULL;
if(is_array($arr1) && is_array($arr2)) {
	$lastarr1 = array_pop($arr1);
	$lastarr2 = array_pop($arr2);
	foreach($arr1 as $key => $value) {
		$result .= $this->purgeinput($arr1[$key]).$b1."'".$this->purgeinput($arr2[$key])."'".$b2;
	}
	$result .= $this->purgeinput($lastarr1).$b1."'".$this->purgeinput($lastarr2)."'";
}
else {
	$result = $this->purgeinput($arr1).$b1."'".$this->purgeinput($arr2)."'";
}
return $result;
}

function purgeinput($unclean) {
	$unclean = trim($unclean);
	$unclean = $this->connection->real_escape_string ($unclean);
	$heresy = array(":",";",".",",","IF","%","&","-","#","/","*","'",'"',"<",">"," ","0x","0X","\n","\r");
	foreach($heresy as $heretic) {
		$unclean = str_replace($heretic,"",$unclean);
	}
//i doubt if the quotes are cleansed properly, better safe than sorry.
	$unclean = addslashes($unclean);
	$clean = $unclean;
	return $clean;
}

function array2string($origin) {
	if(is_array($origin)) {
		foreach($origin as $key => $value) {
			$origin[$key] = $this->purgeinput($value);
		}
		$result = implode(", ",$origin);
	}
	else {
		$result = $this->purgeinput($origin);
	}
	return $result;
}

}

$database = new database();
?>