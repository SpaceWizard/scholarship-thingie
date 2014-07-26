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

private function disconnect() {
	if((!$this->connection)&&self::$debug) {
		die("no connection");
	}
	$this->stmt->free_result();
	$this->stmt->close();
	$this->connection->close();
}

function autenticate($ufid,$password) {
	$this->connect();
	//sanitize input
	$ufid = $this->purgeinput($ufid);
	$password = $this->purgeinput($password);
	$this->stmt = $this->connection->prepare("
		SELECT class
		FROM users
		WHERE ufid=? AND password=?
		LIMIT 1
	");
	if((!$this->stmt)&&self::$debug) {
		die("preparation failed".$this->connection->error);
	}
// use gauss as user class, "class" iz already taken
	$gauss = NULL;
//	$result = array();
	$this->stmt->bind_param("ss",$ufid,$password);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($gauss);
	while($this->stmt->fetch()) {
		$result = $gauss;
	}
	$this->disconnect();
	if(isset($gauss)) {
		return purgeoutput($result);
	}
	else {
		return FALSE;
	}
}

function checkexist($vars,$columns,$table) {
	$this->connect();
	//$var1 = $this->purgeinput($var1);
	//$column1 = $this->purgeinput($column1);
	//$var2 = $this->purgeinput($var2);
	//$column2 = $this->purgeinput($column2);
	$table = $this->purgeinput($table);
	$constraint = $this->complexarray2string($columns,$vars," = "," AND ");
	$this->stmt = $this->connection->prepare("
		SELECT ".$columns[0]."
		FROM ".$table."
		WHERE ".$constraint."
		LIMIT 1
	");
	//die(" SELECT ".$columns[0]." FROM ".$table." WHERE ".$constraint." LIMIT 1 ");
	if((!$this->stmt)&&self::$debug) {
		die("preparation failed".$this->connection->error);
	}
	//$this->stmt->bind_param("ss",$var1,$var2);
	$this->stmt->execute();
	$this->stmt->store_result();
	$result = array();
	$this->stmt->bind_result($result);
	while($this->stmt->fetch()) {
		$result1 = $result;
		null;
	}
	$this->disconnect();
	if(isset($result1)) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

/*function checkexist($var1,$column1,$var2,$column2,$table) {
	$this->connect();
	$var1 = $this->purgeinput($var1);
	$column1 = $this->purgeinput($column1);
	$var2 = $this->purgeinput($var2);
	$column2 = $this->purgeinput($column2);
	$table = $this->purgeinput($table);
	$this->stmt = $this->connection->prepare("
		SELECT ".$column1.", ".$column2."
		FROM ".$table."
		WHERE ".$column1."=? AND ".$column2."=?
		LIMIT 1
	");
	if((!$this->stmt)&&self::$debug) {
		die("preparation failed".$this->connection->error);
	}
	$this->stmt->bind_param("ss",$var1,$var2);
	$this->stmt->execute();
	$this->stmt->store_result();
	$result = array();
	$this->stmt->bind_result($result1,$result2);
	while($this->stmt->fetch()) {
//		$result = $gauss;
		null;
	}
	$this->disconnect();
	if(isset($result1)&&isset($result2)) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function checkexist3($var1,$column1,$var2,$column2,$var3,$column3,$table) {
	$this->connect();
	$var1 = $this->purgeinput($var1);
	$column1 = $this->purgeinput($column1);
	$var2 = $this->purgeinput($var2);
	$column2 = $this->purgeinput($column2);
	$var3 = $this->purgeinput($var3);
	$column3 = $this->purgeinput($column3);
	$table = $this->purgeinput($table);
	$this->stmt = $this->connection->prepare("
		SELECT ".$column1.", ".$column2.", ".$column3."
		FROM ".$table."
		WHERE ".$column1."=? 
		AND ".$column2."=? 
		AND ".$column3."=?
		LIMIT 1
	");
	if((!$this->stmt)&&self::$debug) {
		die("preparation failed".$this->connection->error);
	}
	$this->stmt->bind_param("sss",$var1,$var2,$var3);
	$this->stmt->execute();
	$this->stmt->store_result();
	$result = array();
	$this->stmt->bind_result($result1,$result2,$result3);
	while($this->stmt->fetch()) {
//		$result = $gauss;
		null;
	}
	$this->disconnect();
	if(isset($result1)&&isset($result2)&&isset($result3)) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}*/

function getcolum($colum,$table,$primary,$values = NULL) {
	$this->connect();
	$colum = $this->purgeinput($colum);
	$table = $this->purgeinput($table);
	$pk = $this->array2string($primary);
	if(!isset($values)){
		$this->stmt = $this->connection->prepare("
			SELECT ".$colum."
			FROM ".$table."
			ORDER BY ".$pk." DESC
		");
	}
	else {
		$constraint = $this->complexarray2string($primary,$values," = "," AND ");
		$this->stmt = $this->connection->prepare("
			SELECT ".$colum."
			FROM ".$table."
			WHERE ".$constraint."
		");
	}
	$result = array();
	$component = NULL;
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($component);
	while($this->stmt->fetch()) {
		$result[] = $component;
	}
	$this->disconnect();
	if(isset($result)) {
		return $result;
	}
	else {
		return FALSE;
	}
}

/*function getcolum($colum,$table,$primary) {
	$this->connect();
	//sanitize input
	$colum = $this->purgeinput($colum);
	$table = $this->purgeinput($table);
	$pk = $this->array2string($primary);
	$this->stmt = $this->connection->prepare("
		SELECT ".$colum."
		FROM ".$table."
		ORDER BY ".$pk." DESC
	");
	$result = array();
	$yaranaika = NULL;
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($yaranaika);
	while($this->stmt->fetch()) {
		$result[] = purgeoutput($yaranaika);
	}
	$this->disconnect();
	if(isset($result)) {
		return $result;
	}
	else {
		return FALSE;
	}
}*/

function getelementfromrow($colum,$row,$table,$pk) {
	$this->connect();
	//sanitize input
	$colum = $this->purgeinput($colum);
	$row = $this->purgeinput($row);
	$table = $this->purgeinput($table);
	$pk = $this->purgeinput($pk);
	//$pk = $this->array2string($pk);
	$this->stmt = $this->connection->prepare("
		SELECT ".$colum."
		FROM ".$table."
		WHERE ".$pk." = ?
		LIMIT 1
	");
	$this->stmt->bind_param("s",$row);
	$yaranaika = NULL;
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($yaranaika);
	$this->stmt->fetch();
	$this->disconnect();
	if(isset($yaranaika)) {
		return purgeoutput($yaranaika);
	}
	else {
		return FALSE;
	}
}

function geteverything($colums,$table,$pk) {
	$result = array();
	foreach($colums as $colum) {
		$result[] = $this->getcolum($colum,$table,$pk);
	}
	if(isset($result)) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function deletrows($pks,$keys,$table) {
	$this->connect();
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
		$this->disconnect();
		return TRUE;
	}
	else {
		$this->disconnect();
		return FALSE;
	}
}

/*function deletrow($key,$table,$pk) {
	$this->connect();
	$key = $this->purgeinput($key);
	$table = $this->purgeinput($table);
	$pk = $this->purgeinput($pk);
	$this->stmt = $this->connection->prepare("
		DELETE FROM ".$table."
		WHERE ".$pk." = '".$key."'
	");
	//$this->stmt->bind_param("s",$key);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		$this->disconnect();
		return TRUE;
	}
	else {
		$this->disconnect();
		return FALSE;
	}
}

function deletrow2($pk1,$key1,$pk2,$key2,$table) {
	$this->connect();
	$key1 = $this->purgeinput($key1);
	$pk1 = $this->purgeinput($pk1);
	$key2 = $this->purgeinput($key2);
	$pk2 = $this->purgeinput($pk2);
	$table = $this->purgeinput($table);
	$this->stmt = $this->connection->prepare("
		DELETE FROM ".$table."
		WHERE ".$pk1." = '".$key1."' AND ".$pk2." = '".$key2."'
	");
	//$this->stmt->bind_param("s",$key);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		$this->disconnect();
		return TRUE;
	}
	else {
		$this->disconnect();
		return FALSE;
	}
}*/

function updatecolum($key,$value,$table,$colum,$pk) {
	$this->connect();
	$key = $this->purgeinput($key);
	$value = $this->purgeinput($value);
	$table = $this->purgeinput($table);
	$colum = $this->purgeinput($colum);
	$pk = $this->purgeinput($pk);
//	$pk = $this->array2string($pk);
	$this->stmt = $this->connection->prepare("
		UPDATE ".$table."
		SET ".$colum." = ?
		WHERE ".$pk." = ?
		LIMIT 1
	");
	$this->stmt->bind_param("ss",$value,$key);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		$this->disconnect();
		return TRUE;
	}
	else {
		$this->disconnect();
		return FALSE;
	}
}

function massupdate($keys,$values,$table,$colums,$pk) {
	$this->connect();
	$table = $this->purgeinput($table);
	$valueset = $this->complexarray2string($colums,$values," = ",", ");
	$keymatch = $this->complexarray2string($pk,$keys," = "," AND ");
	$this->stmt = $this->connection->prepare("
		UPDATE ".$table."
		SET ".$valueset."
		WHERE ".$keymatch."
	");
/*	die("
		UPDATE ".$table."
		SET ".$valueset."
		WHERE ".$keymatch."
	");*/
//	$this->stmt->bind_param("ss",$value,$key);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		$this->disconnect();
		return TRUE;
	}
	else {
		$this->disconnect();
		return FALSE;
	}
}

/*function updateall($key,$values,$table,$colums,$pk) {
	$i = NULL;
	$colum_num = count($colums);
	for($i=0;$i<$colum_num;$i++) {
		updatecolum($key,$values[$i],$table,$colums[$i],$pk);
	}
}*/

function insertrow($values,$table,$columns) {
	$this->connect();
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
		$this->disconnect();
		return TRUE;
	}
	else {
		$this->disconnect();
		return FALSE;
	}	
}

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
	$this->connect();
	$table = $this->purgeinput($table);
	$this->stmt = $this->connection->prepare("
		SELECT *
		FROM ".$table."
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$row_num = $this->stmt->num_rows();
	$this->disconnect();
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