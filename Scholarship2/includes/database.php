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
	$gauss = NULL;
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($ivpassword,$iv,$gauss);
	$this->stmt->fetch();	
	if(!isset($ivpassword)) {		
		return FALSE;
	}
	$actualpass = aesdecrypt($ivpassword,$iv);
	if($actualpass == $password) {
		return purgeoutput($gauss);		
	}
	else {
		return FALSE;
	}
}

function getpassword($ufid) {
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
	$password = aesdecrypt($ivpassword,$iv);
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
	$this->stmt->bind_param("s",$user);
	$user_class = NULL;
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($user_class);
	$this->stmt->fetch();
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
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function get_stu($ufid) {
	$this->stmt = $this->connection->prepare("
		SELECT *
		FROM students
		WHERE ufid=?
		LIMIT 1
	");
	$this->stmt->bind_param("s",$ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($ufid,$name,$degree,$program_major,$graduate_time,$current,$GPA,$highschool,
	$college,$lockon,$local_address,$perm_address,$email,$local_phone,$perm_phone,$specializations);
	$result = array();
	$this->stmt->fetch();
	$result["name"] = $name;
	$result["degree"] = $degree;
	$result["program_major"] = $program_major;
	$result["graduate_time"] = $graduate_time;
	$result["current"] = $current;
	$result["GPA"] = $GPA;
	$result["highschool"] = $highschool;
	$result["college"] = $college;
	$result["lockon"] = $lockon;
	$result["local_address"] = $local_address;
	$result["perm_address"] = $perm_address;
	$result["email"] = $email;
	$result["local_phone"] = $local_phone;
	$result["perm_phone"] = $perm_phone;
	$result["specializations"] = $specializations;
	//die(json_encode($result));
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function get_scholarship($scholarship) {
	$this->stmt = $this->connection->prepare("
		SELECT quantity,award,deadline
		FROM scholarships
		WHERE title=?
	");
	$this->stmt->bind_param("s",$scholarship);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($quantity,$award,$deadline);
	$result = array();
	$this->stmt->fetch();
	$result["quantity"] = $quantity;
	$result["award"] = $award;
	$result["deadline"] = $deadline;
	//die(json_encode($result));
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function get_stus() {
	$this->stmt = $this->connection->prepare("
		SELECT *
		FROM students
	");
	//$this->stmt->bind_param("s",$ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($ufid,$name,$degree,$program_major,$graduate_time,$current,$GPA,$highschool,
	$college,$lockon,$local_address,$perm_address,$email,$local_phone,$perm_phone,$specializations);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["ufid"] = $ufid;
		$result[$i]["name"] = $name;
		$result[$i]["degree"] = $degree;
		$result[$i]["program_major"] = $program_major;
		$result[$i]["graduate_time"] = $graduate_time;
		$result[$i]["current"] = $current;
		$result[$i]["GPA"] = $GPA;
		$result[$i]["highschool"] = $highschool;
		$result[$i]["college"] = $college;
		$result[$i]["lockon"] = $lockon;
		$result[$i]["local_address"] = $local_address;
		$result[$i]["perm_address"] = $perm_address;
		$result[$i]["email"] = $email;
		$result[$i]["local_phone"] = $local_phone;
		$result[$i]["perm_phone"] = $perm_phone;
		$result[$i]["specializations"] = $specializations;
	}
	//die(json_encode($result));
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function get_scholarships() {
	$this->stmt = $this->connection->prepare("
		SELECT title,quantity,award,deadline
		FROM scholarships
		ORDER BY title ASC
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($title,$quantity,$award,$deadline);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["title"] = $title;
		$result[$i]["quantity"] = $quantity;
		$result[$i]["award"] = $award;
		$result[$i]["deadline"] = $deadline;
	}
	//die(json_encode($result));
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}



function get_sch_constraint($scholarship) {
	$this->stmt = $this->connection->prepare("
		SELECT scholarship,con,weight
		FROM scholarship_constraint
		WHERE scholarship=?
	");
	$this->stmt->bind_param("s",$scholarship);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($scholarship,$con,$weight);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["scholarship"] = $scholarship;
		$result[$i]["con"] = $con;
		$result[$i]["weight"] = $weight;
	}
	//die(json_encode($result));
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function get_sch_requirement($scholarship) {
	$this->stmt = $this->connection->prepare("
		SELECT title,attribute,content,weight
		FROM scholarship_requirement
		WHERE title=?
	");
	$this->stmt->bind_param("s",$scholarship);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($title,$attribute,$content,$weight);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["title"] = $title;
		$result[$i]["attribute"] = $attribute;
		$result[$i]["content"] = $content;
		$result[$i]["weight"] = $weight;
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
	//$ufid = $this->purgeinput($ufid);
	//$class = $this->purgeinput($class);
	//$password = $this->purgeinput($password);
	$password_return = aesencrypt($password);
	if($class == "student") {
		$this->stmt = $this->connection->prepare("
			INSERT INTO students (ufid)
			VALUES (? )
		");
		$this->stmt->bind_param("s",$ufid);
		$this->stmt->execute();
		$this->stmt->store_result();
	}
	else if($class == "committee") {
		$this->stmt = $this->connection->prepare("
			INSERT INTO committee_members (userName)
			VALUES (? )
		");
		$this->stmt->bind_param("s",$ufid);
		$this->stmt->execute();
		$this->stmt->store_result();
	}
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

function create_stu($ufid) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO students (ufid)
		VALUES (? )
	");
	$this->stmt->bind_param("s",$ufid);
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

function add_scholarship($title,$quantity,$award,$deadline) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO scholarships (title,quantity,award,deadline)
		VALUES (?, ?, ?, ? )
	");
	$this->stmt->bind_param("siis",$title,$quantity,$award,$deadline);
	if(!$this->stmt) die("preparation failed");
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

function delete_stu($ufid) {
	$this->stmt = $this->connection->prepare("
		DELETE 
		FROM students
		WHERE ufid=?
	");
	$this->stmt->bind_param("s",$ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function delete_scholarship($title, $amount) {
	$this->stmt = $this->connection->prepare("
		DELETE 
		FROM scholarships
		WHERE title=?, award=?
	");
	$this->stmt->bind_param("si",$title,$amount);
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

function list_major() {
	$this->stmt = $this->connection->prepare("
		SELECT major
		FROM majors
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

function list_highschool() {
	$this->stmt = $this->connection->prepare("
		SELECT highschool,location
		FROM highschools
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$not_chosen = array();
	$this->stmt->bind_result($highschool,$location);
	while($this->stmt->fetch()) {
		$not_chosen[$highschool] = $location;
	}
	if(count($not_chosen) != 0) {
		return $not_chosen;
	}
	else {
		return FALSE;
	}
}

function list_college() {
	$this->stmt = $this->connection->prepare("
		SELECT college,location
		FROM colleges
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$not_chosen = array();
	$this->stmt->bind_result($college,$location);
	while($this->stmt->fetch()) {
		$not_chosen[$college] = $location;
	}
	if(count($not_chosen) != 0) {
		return $not_chosen;
	}
	else {
		return FALSE;
	}
}

function list_constraint() {
	$this->stmt = $this->connection->prepare("
		SELECT title,question
		FROM constraints
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($title,$question);
	while($this->stmt->fetch()) {
		$output[$title] = $question;
	}
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function list_scholarship() {
	$this->stmt = $this->connection->prepare("
		SELECT title, award,quantity
		FROM scholarships
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($title,$award,$quantity);
	For($i=0;$this->stmt->fetch();$i++){
		$output[$i]["title"] = $title;
		$output[$i]["amount"]=$award;
		$output[$i]["quantity"]=$quantity;
	}
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function list_scholarships_requirements($scholarship, $award){
	$this->stmt=$this->connection->prepare("
		SELECT requirements.ShortName, requirements.Description 
			FROM
				requirements
				JOIN scholarship_requirements 
				ON scholarship_requirements.Requirement = requirements.ShortName
		WHERE ScholarshipName =?
			AND awardAmount =?
			AND scholarship_requirements.Weight=0;
		");
	if(!$this->stmt){
		die("list_scholarships_requirements stmt failed");
	}
	$this->stmt->bind_param("si",$scholarship, $award);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($ShortName, $Description);
	For($i=0;$this->stmt->fetch();$i++){
		$output[$i]["shortName"]=$ShortName;
		$output[$i]["description"]=$Description;
	}
	if(count($output)!=0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function delete_scholarship_requirement($scholarship, $award, $shortName){
	$this->stmt=$this->connection->prepare("
		DELETE 
		FROM scholarship_requirements
		WHERE ScholarshipName =?
		AND awardAmount =?
		AND Requirement=?
	");
	if(!$this->stmt){
		die("delete_scholarship_requirement stmt failed");
	}
	$this->stmt->bind_param("sis",$scholarship, $award, $shortName);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function list_or_scholarship_requirements($scholarship, $award){
	$this->stmt=$this->connection->prepare("
		SELECT requirements.ShortName, requirements.Description
			FROM
				requirements
				JOIN scholarship_requirements
				ON scholarship_requirements.Requirement = requirements.ShortName
		WHERE ScholarshipName =?
			AND awardAmount =?
			AND scholarship_requirements.Weight<>0;
		");
	if(!$this->stmt){
		die("list_or_scholarship_requirements stmt failed");
	}
	$this->stmt->bind_param("si",$scholarship, $award);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($ShortName, $Description);
	For($i=0;$this->stmt->fetch();$i++){
		$output[$i]["shortName"]=$ShortName;
		$output[$i]["description"]=$Description;
	}
	if(count($output)!=0) {
		return $output;
	}
	else {
		return "none";
	}
}

function list_requirements_Scholar_notUsed($scholarship, $amount){
	$this->stmt=$this->connection->prepare("
		SELECT ShortName, Description
		FROM requirements
			LEFT JOIN (	SELECT  ScholarshipName, Requirement
			FROM
				scholarship_requirements	
			WHERE 
				ScholarshipName =?
				AND awardAmount =?) AS used ON used.Requirement = requirements.ShortName
		WHERE ScholarshipName IS NULL
	");
	if(!$this->stmt) {
		die("pp failed");
	}
	$this->stmt->bind_param("si",$scholarship,$amount);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($shortName,$description);
	For($i=0;$this->stmt->fetch();$i++){
		$output[$i]["shortName"]=$shortName;
		$output[$i]["description"]=$description;
	}
	if(count($output)!=0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function add_req($shortName, $Description){
	$this->stmt=$this->connection->prepare("
		INSERT INTO requirements VALUES (?,?)
			");
	if(!$this->stmt) {
		die("pp failed");
	}
	$this->stmt->bind_param("ss",$shortName, $Description);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function schol_req_add($scholarship, $award, $req, $weight){
	$this->stmt =$this->connection->prepare("
		INSERT INTO scholarship_requirements VALUES (?,?,?,?)
			");
	if(!$this->stmt) {
		die("pp failed");
	}
	$this->stmt->bind_param("sisi",$scholarship,$award,$req,$weight);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function list_stu_constraint($student) {
	$this->stmt = $this->connection->prepare("
		SELECT constraints.title, constraints.question
		FROM stu_constraint
		JOIN constraints
		USING (title)
		WHERE stu_constraint.student=?
	");
	if(!$this->stmt) {
		die("pp failed");
	}
	$this->stmt->bind_param("s",$student);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($title,$question);
	while($this->stmt->fetch()) {
		$output[$title] = $question;
	}
	if(count($output) != 0) {
		//die(json_encode($output));
		return $output;
	}
	else {
		return FALSE;
	}
}

function list_sch_requirement($scholarship) {
	$this->stmt = $this->connection->prepare("
		SELECT attribute, content, weight
		FROM scholarship_requirement
		WHERE title=?
	");
	if(!$this->stmt) {
		die("pp failed");
	}
	$this->stmt->bind_param("s",$scholarship);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($attribute,$content,$weight);
	for($i=0;$this->stmt->fetch();$i++){
		$output[$i]["attribute"] = $attribute;
		$output[$i]["content"] = $content;
		$output[$i]["weight"] = $weight;	
	}
	if(count($output) != 0) {
		//die(json_encode($output));
		return $output;
	}
	else {
		return FALSE;
	}
}

function list_sch_constraint($scholarship) {
	$this->stmt = $this->connection->prepare("
		SELECT title,question
		FROM constraints
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($title,$question);
	while($this->stmt->fetch()) {
		$output[$title] = $question;
	}
	if(count($output) != 0) {
		return $output;
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

function insert_stu_con($student,$constraint) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO stu_constraint (student,title)
		VALUES (? , ? )
	");
	$this->stmt->bind_param("ss",$student,$constraint);
	if(!$this->stmt) die("preparation failed");
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

function insert_sch_con($scholarship,$con,$weight) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO scholarship_constraint (scholarship,con,weight)
		VALUES (?, ?, ? )
	");
	$this->stmt->bind_param("ssi",$scholarship,$con,$weight);
	if(!$this->stmt) die("preparation failed");
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function insert_sch_requirement($scholarship,$attribute,$content,$weight) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO scholarship_requirement (title,attribute,content,weight)
		VALUES (?, ?, ?, ? )
	");
	$this->stmt->bind_param("sssi",$scholarship,$attribute,$content,$weight);
	if(!$this->stmt) die("preparation failed");
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

function delete_stu_con($student,$title) {
	$this->stmt = $this->connection->prepare("
		DELETE 
		FROM stu_constraint
		WHERE student=?
		AND title=?
	");
	$this->stmt->bind_param("ss",$student,$title);
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

function delete_sch_con($scholarship,$con) {
	$this->stmt = $this->connection->prepare("
		DELETE 
		FROM scholarship_constraint
		WHERE scholarship=?
		AND con=?
	");
	$this->stmt->bind_param("ss",$scholarship,$con);
	if(!$this->stmt) die("preparation failed");
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function delete_sch_requirement($scholarship,$requirement) {
	$this->stmt = $this->connection->prepare("
		DELETE 
		FROM scholarship_requirement
		WHERE title=?
		AND attribute=?
	");
	$this->stmt->bind_param("ss",$scholarship,$requirement);
	if(!$this->stmt) die("preparation failed");
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

/*function get_scholarship($title) {
	$this->stmt = $this->connection->prepare("
		SELECT title,quantity,award,deadline
		FROM scholarships
		WHERE title=?
		LIMIT 1
	");
	$this->stmt->bind_param("s",$title);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($title,$quantity,$award,$deadline);
	$result = array();
	$this->stmt->fetch();
	$result["title"] = $title;
	$result["quantity"] = $quantity;
	$result["award"] = $award;
	$result["deadline"] = $deadline;
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}*/

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

function update_stu($ufid,$name="",$degree="",$program_major="",$graduate_time="0000-00-00",$current=0,$highschool="",
$college="",$local_address="",$perm_address="",$email="",$local_phone="",$perm_phone="",$specializations="",$GPA=0,$lockon=0) {
	$this->stmt = $this->connection->prepare("
		UPDATE students
		SET name=?, degree=?, program_major=?, graduate_time=?, current=?, highschool=?, college=?, local_address=?, perm_address=?, email=?, local_phone=?, perm_phone=?, specializations=?, GPA=?, lockon=? 
		WHERE ufid=?;
	");
	$this->stmt->bind_param("ssssissssssssiis",$name,$degree,$program_major,$graduate_time,$current,$highschool,
	$college,$local_address,$perm_address,$email,$local_phone,$perm_phone,$specializations,$GPA,$lockon,$ufid);
	if(!$this->stmt) die("preparation failed");
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function update_scholarship($title,$quantity,$award,$deadline,$newtitle, $newaward) {
	$this->stmt = $this->connection->prepare("
		UPDATE scholarships
		SET quantity=?, award=?, deadline=?, title=?
		WHERE title=? AND award=?;
	");
	$this->stmt->bind_param("iisssi",$quantity,$newaward,$deadline,$newtitle,$title,$award);
	if(!$this->stmt) die("preparation failed");
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function update_sch_con($scholarship,$con,$weight) {
	$this->stmt = $this->connection->prepare("
		UPDATE scholarship_constraint
		SET weight=?
		WHERE scholarship=? AND con=?;
	");
	$this->stmt->bind_param("iss",$weight,$scholarship,$con);
	if(!$this->stmt) die("preparation failed");
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function update_sch_requirement($scholarship,$attribute,$content,$weight) {
	$this->stmt = $this->connection->prepare("
		UPDATE scholarship_requirement
		SET content=?,weight=?
		WHERE title=? AND attribute=?;
	");
	$this->stmt->bind_param("siss",$content,$weight,$scholarship,$attribute);
	if(!$this->stmt) die("preparation failed");
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function list_scholarship_pref($scholarship,$amount){
	$this->stmt=$this->connection->prepare("
		SELECT Preference, Description, Weight
		FROM scholarship_preferences
			JOIN requirements ON scholarship_preferences.preference = requirements.shortName
		WHERE
			ScholarshipName =?
			AND awardAmount =?
		");
	if(!$this->stmt){
		die("list_scholarship_pref stmt failed");
	}
	$this->stmt->bind_param("si",$scholarship, $amount);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($preference, $Description, $weight);
	For($i=0;$this->stmt->fetch();$i++){
		$output[$i]["preference"]=$preference;
		$output[$i]["description"]=$Description;
		$output[$i]["weight"]=$weight;
	}
	if(count($output)!=0) {
		return $output;
	}else {
		return FALSE;
	}
}

function delete_scholarship_pref($scholarship, $amount, $prefer){
	$this->stmt=$this->connection->prepare("
		DELETE
		FROM scholarship_preferences
		WHERE ScholarshipName=?
		AND	AwardAmount=?
		AND Preference=?
	");
	if(!$this->stmt){
		die("delete_scholarship_pref stmt failed");
	}
	$this->stmt->bind_param("sis",$scholarship, $amount, $prefer);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function list_possible_pref($scholarship,$amount){
	$this->stmt=$this->connection->prepare("
SELECT ShortName, Description
FROM requirements
	LEFT JOIN (	SELECT  ScholarshipName, Preference
	FROM
		scholarship_preferences	
	WHERE 
		ScholarshipName =?
		AND awardAmount =?) AS used ON used.Preference = requirements.ShortName
WHERE ScholarshipName IS NULL
	");
	if(!$this->stmt) {
		die("pp failed");
	}
	$this->stmt->bind_param("si",$scholarship,$amount);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($shortName,$description);
	For($i=0;$this->stmt->fetch();$i++){
		$output[$i]["shortName"]=$shortName;
		$output[$i]["description"]=$description;
	}
	if(count($output)!=0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function schol_pref_add($scholarship, $award, $pref, $weight){
	$this->stmt =$this->connection->prepare("
		INSERT INTO scholarship_preferences VALUES (?,?,?,?)
			");
	if(!$this->stmt) {
		die("pp failed");
	}
	$this->stmt->bind_param("sisi",$scholarship,$award,$pref,$weight);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function Get_Committees(){
	$this->stmt =$this->connection->prepare("
		SELECT DISTINCT Committee FROM committee
	");
	if(!$this->stmt) {
		die("pp failed");
	}
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($committee);
	while($this->stmt->fetch()) {
		$output[] = $committee;
	}
	if(count($output)!=0) {
		return $output;
	}else {
		return FALSE;
	}
}

function app_done($ufid){
	$this->stmt =$this->connection->prepare("
		SELECT ApplicationComp
		FROM students
		WHERE ufid = ?
	");
	if(!$this->stmt) {
		die("app_done stmt failed");
	}
	$this->stmt->bind_param("s", $ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($appCom);
	while($this->stmt->fetch()){
		$output[]=$appCom;
	}
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function app_start($ufid){
	$this->stmt =$this->connection->prepare("
		SELECT ApplicationStarted
		FROM students
		WHERE ufid = ?
	");
	if(!$this->stmt) {
		die("app_start stmt failed");
	}
	$this->stmt->bind_param("s", $ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($appCom);
	while($this->stmt->fetch()){
		$output[]=$appCom;
	}
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function getStuAppData($ufid){
	$this->stmt =$this->connection->prepare("
		SELECT name, local_address, perm_address, email, local_phone, perm_phone, current, program_major, specializations, degree, graduate_time, GPA, GRE_SAT_ACT
		FROM students
		WHERE ufid=?
	");
	if(!$this->stmt) {
		die("getStuAppData stmt failed");
	}
	$this->stmt->bind_param("s", $ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($name,$localAdd,$permAdd,$email,$localPhone,$permPhone,$current,$major,$special,$degree,$grad,$gpa,$gre);
	while($this->stmt->fetch()){
		$output["name"]=$name;
		$output["localAdd"]=$localAdd;
		$output["permAdd"]=$permAdd;
		$output["email"]=$email;
		$output["localPhone"]=$localPhone;
		$output["permPhone"]=$permPhone;
		$output["current"]=$current;
		$output["major"]=$major;
		$output["special"]=$special;
		$output["degree"]=$degree;
		$output["grad"]=$grad;
		$output["gpa"]=$gpa;
		$output["gre"]=$gre;
	}
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function setAppStart($ufid){
	$this->stmt =$this->connection->prepare("
		UPDATE students
		SET ApplicationStarted = 1
		WHERE ufid=?
	");
	if(!$this->stmt) {
		die("setAppStart stmt failed");
	}
	$this->stmt->bind_param("s", $ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function updateStudentApp($ufid,$name,$locAdd,$permAdd,$email,$locPhone,$permPhone,$current,$major,$special,$degree,$grad,$gpa,$gre){
	$this->stmt =$this->connection->prepare("
		UPDATE students
		SET name=?, local_address=?, perm_address=?, email=?, local_phone=?, perm_phone=?, 
			current=?, program_major=?, specializations=?, degree=?, graduate_time=?, GPA=?, GRE_SAT_ACT=?
		WHERE ufid=?
	");
	if(!$this->stmt) {
		die("updateStudentApp stmt failed");
	}
	$this->stmt->bind_param("ssssssissssdis",$name,$locAdd,$permAdd,$email,$locPhone,$permPhone,$current,$major,$special,$degree,$grad,$gpa,$gre,$ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function updateStudentAddMat($ufid,$essay,$transcr,$resume){
	$this->stmt =$this->connection->prepare("
		UPDATE student_extra_materials
		SET Essay=?, Transcript=?, Resume=?
		WHERE student=?
	");
	if(!$this->stmt) {
		die("updateStudentAddMat stmt failed");
	}
	$this->stmt->bind_param("ssss",$essay,$transcr,$resume,$ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}	
}

function checkStudentAddMat($ufid){
	$this->stmt =$this->connection->prepare("
		SELECT student
		FROM student_extra_materials
		WHERE student=?
	");
	if(!$this->stmt) {
		die("checkStudentAddMat stmt failed");
	}
	$this->stmt->bind_param("s", $ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($name);
	while($this->stmt->fetch()){
		$output[]=$name;
	}
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function addUfidScholMat($ufid){
	$this->stmt =$this->connection->prepare("
		INSERT INTO student_extra_materials (student)
		VALUES (?)
	");
	if(!$this->stmt) {
		die("addUfidScholMat stmt failed");
	}
	$this->stmt->bind_param("s",$ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function getSavedAddMat($ufid){
	$this->stmt =$this->connection->prepare("
		SELECT Essay, Transcript, Resume
		FROM student_extra_materials
		WHERE student=?
	");
	if(!$this->stmt) {
		die("getSavedAddMat stmt failed");
	}
	$this->stmt->bind_param("s", $ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($essay,$trans,$resume);
	while($this->stmt->fetch()){
		$output["essay"]=$essay;
		$output["transcript"]=$trans;
		$output["resume"]=$resume;
	}
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function listRequirements(){
	$this->stmt =$this->connection->prepare("
		SELECT ShortName, Description
		FROM requirements
	");
	if(!$this->stmt) {
		die("listRequirements stmt failed");
	}
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($shortName,$descrip);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["shortName"] = $shortName;
		$result[$i]["description"] = $descrip;
	}
	if(count($result) != 0) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function addStudentRequ($ufid,$value){
	$this->stmt =$this->connection->prepare("
		INSERT INTO student_requirements
		VALUES(?,?)
	");
	if(!$this->stmt) {
		die("addStudentRequ stmt failed");
	}
	$this->stmt->bind_param("ss",$ufid,$value);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}	
}

function checkStudentRequChecked($ufid,$value){
	$this->stmt =$this->connection->prepare("
		SELECT student
		FROM student_requirements
		WHERE Student=?
		AND Requirement=?
	");
	if(!$this->stmt) {
		die("checkStudentRequChecked stmt failed");
	}
	$this->stmt->bind_param("ss", $ufid, $value);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($name);
	while($this->stmt->fetch()){
		$output[]=$name;
	}
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function deleteAllStudReq($ufid){
	$this->stmt =$this->connection->prepare("
		DELETE
		FROM student_requirements
		WHERE student=?
	");
	if(!$this->stmt) {
		die("deleteAllStudReq stmt failed");
	}
	$this->stmt->bind_param("s", $ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows >= 1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function completeApp($ufid){
	$this->stmt =$this->connection->prepare("
		UPDATE students
		SET ApplicationComp=1
		WHERE ufid=?
	");
	if(!$this->stmt) {
		die("completeApp stmt failed");
	}
	$this->stmt->bind_param("s",$ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}	
}

function studentsNotAssigned(){
	$this->stmt =$this->connection->prepare("
		SELECT students.name, students.ufid
		FROM students
		LEFT JOIN (
			SELECT student, COUNT(committeeMember) AS assing
			FROM committee_students
			GROUP BY student) AS assnCount ON assnCount.student = students.ufid
		WHERE (assnCount.assing <> 2	OR assnCount.assing IS NULL	)
		AND students.ApplicationComp = 1
	");
	if(!$this->stmt) {
		die("studentsNotAssigned stmt failed");
	}
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($name,$id);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["studentName"] = $name;
		$result[$i]["ufid"] = $id;
	}
	if(count($result) != 0) {
		return $result;
	}else {
		return FALSE;
	}
}

function countCommMemByStudent($ufid){
	$this->stmt =$this->connection->prepare("
		SELECT COUNT(committeeMember)
		FROM committee_students
		WHERE student=?
		GROUP BY student
	");
	if(!$this->stmt) {
		die("countCommMemByStudent stmt failed");
	}
	$this->stmt->bind_param("s", $ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($count);
	while($this->stmt->fetch()){
		$output[]=$count;
	}
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function committeeMemNotAss($ufid){
	$this->stmt =$this->connection->prepare("
		SELECT userName, Name
		FROM committee_members
		WHERE username<>(
		SELECT committeeMember
		FROM committee_students
		WHERE student=?)
	");
	if(!$this->stmt) {
		die("committeeMemNotAss stmt failed");
	}
	$this->stmt->bind_param("s", $ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($id,$name);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["ufid"] = $id;
		$result[$i]["memberName"] = $name;
	}
	if(count($result) != 0) {
		return $result;
	}else {
		return FALSE;
	}
}

function listCommitteeMembers(){
	$this->stmt =$this->connection->prepare("
		SELECT userName, Name
		FROM committee_members
	");
	if(!$this->stmt) {
		die("listCommitteeMembers( stmt failed");
	}
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($id,$name);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["ufid"] = $id;
		$result[$i]["memberName"] = $name;
	}
	if(count($result) != 0) {
		return $result;
	}else {
		return FALSE;
	}
}

function getStudentName($ufid){
	$this->stmt =$this->connection->prepare("
		SELECT name
		FROM students
		WHERE ufid=?
	");
	if(!$this->stmt) {
		die("getStudentName stmt failed");
	}
	$this->stmt->bind_param("s", $ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($name);
	while($this->stmt->fetch()){
		$output[]=$name;
	}
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function newStudentCommitteePair($ufid,$comm){
	$this->stmt =$this->connection->prepare("
		INSERT INTO committee_students (student,committeeMember)
		VALUES(?,?)
	");
	if(!$this->stmt) {
		die("newStudentCommitteePair stmt failed");
	}
	$this->stmt->bind_param("ss",$ufid,$comm);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function listStudentForCommNotScore($commMem){
	$this->stmt = $this->connection->prepare("
		SELECT student
		FROM committee_students
		WHERE committeeMember=?
		AND score=0
	");
	$this->stmt->bind_param("s",$commMem);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($student);
	for($i=0;$this->stmt->fetch();$i++) {
		$results[$i]["ufid"] = $student;
	}
	if(count($results) != 0) {
		return $results;
	}else {
		return FALSE;
	}
}

function listStudentForCommScore($commMem){
	$this->stmt = $this->connection->prepare("
		SELECT student, score
		FROM committee_students
		WHERE committeeMember=?
		AND score<>0
	");
	$this->stmt->bind_param("s",$commMem);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($student,$score);
	for($i=0;$this->stmt->fetch();$i++) {
		$results[$i]["ufid"] = $student;
		$results[$i]["score"]=$score;
	}
	if(count($results) != 0) {
		return $results;
	}else {
		return FALSE;
	}
}

function listStudentsForReferer($referer){
	$this->stmt = $this->connection->prepare("
		SELECT student, students.name
		FROM student_referer_list
		JOIN students ON student_referer_list.student = students.ufid
		WHERE reference = ?
		AND Complete=0
	");
	$this->stmt->bind_param("s",$referer);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($studentID, $studentName);
	for($i=0;$this->stmt->fetch();$i++) {
		$results[$i]["ufid"] = $studentID;
		$results[$i]["name"]= $studentName;
	}
	if(count($results) != 0) {
		return $results;
	}else {
		return FALSE;
	}
}

function recordReference($referer,$student,$item,$score){
	$this->stmt =$this->connection->prepare("
		INSERT INTO recommendations (recommender, student, item, score)
		VALUES (?,?,?,?)
	");
	if(!$this->stmt) {
		die("recordReference stmt failed");
	}
	$this->stmt->bind_param("ssss",$referer,$student,$item,$score);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows>=1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function completedReference($referer, $student){
	$this->stmt =$this->connection->prepare("
		UPDATE student_referer_list
		SET Complete = 1
		WHERE student=?
		AND Reference=?
	");
	if(!$this->stmt) {
		die("completedReference stmt failed");
	}
	$this->stmt->bind_param("ss",$student,$referer);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function listStudentsReferered($referer){
	$this->stmt = $this->connection->prepare("
		SELECT student, students.name
		FROM student_referer_list
		JOIN students ON student_referer_list.student = students.ufid
		WHERE reference = ?
		AND Complete=1
	");
	$this->stmt->bind_param("s",$referer);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($studentID, $studentName);
	for($i=0;$this->stmt->fetch();$i++) {
		$results[$i]["ufid"] = $studentID;
		$results[$i]["name"]= $studentName;
	}
	if(count($results) != 0) {
		return $results;
	}else {
		return FALSE;
	}
}

function getReferenceData($refer, $student, $item){
	$this->stmt = $this->connection->prepare("
		SELECT score
		FROM recommendations
		WHERE recommender = ?
		AND Student = ?
		AND Item = ?
	");
	$this->stmt->bind_param("sss",$refer,$student,$item);	
	$this->stmt->execute();		
	$this->stmt->store_result();	
	$results = array();
	$this->stmt->bind_result($score);
	while($this->stmt->fetch()){
		$results[]=$score;
	}
	if(count($results) != 0) {
		return $results;
	}
	else {
		return FALSE;
	}
}

function removeReference($ufid,$student,$key){
	$this->stmt =$this->connection->prepare("
		DELETE FROM recommendations
		WHERE recommender = ?
		AND Student = ? 
		AND Item = ?
	");
	if(!$this->stmt) {
		die("removeReference stmt failed");
	}
	$this->stmt->bind_param("sss",$ufid,$student,$key);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows>=1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function getCurrentCommScore($comm,$student,$item=NULL){
	if($item==NULL) {
		$this->stmt = $this->connection->prepare("
			SELECT sum(score)
			FROM committee_item_score
			WHERE committeeMember = ?
			AND student = ?
		");
		$this->stmt->bind_param("ss",$comm,$student);
	}
	else {
		$this->stmt = $this->connection->prepare("
			SELECT score
			FROM committee_item_score
			WHERE committeeMember = ?
			AND student = ?
			AND item = ?
		");
		$this->stmt->bind_param("sss",$comm,$student,$item);
	}
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($score);
	$this->stmt->fetch();
	if(isset($score)) {
		return $score;
	}
	else {
		return FALSE;
	}
}

function getStudentGPA($student){
	$this->stmt = $this->connection->prepare("
		SELECT GPA
		FROM students
		WHERE ufid=?
	");
	$this->stmt->bind_param("s",$student);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($gpa);
	$this->stmt->fetch();
	if(isset($gpa)) {
		return $gpa;
	}
	else {
		return FALSE;
	}
}

function listStudents(){
	$this->stmt = $this->connection->prepare("
		SELECT ufid, name, score
		FROM students
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($studentID, $studentName, $score);
	for($i=0;$this->stmt->fetch();$i++) {
		$results[$i]["ufid"] = $studentID;
		$results[$i]["name"]= $studentName;
		$results[$i]["score"]= $score;
	}
	if(count($results) != 0) {
		return $results;
	}else {
		return FALSE;
	}
}

function studentMetReq($student,$req){
	$this->stmt = $this->connection->prepare("
		SELECT student
		FROM student_requirements
		WHERE student = ?
		AND Requirement = ?
	");
	$this->stmt->bind_param("ss",$student,$req);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($student);
	while($this->stmt->fetch()){
		$results[]=$student;
	}
	if(count($results) != 0) {
		return 1;
	}
	else {
		return 0;
	}
}

function scholarshipMetReq($scholar,$award,$req){
	$this->stmt = $this->connection->prepare("
		SELECT ScholarshipName
		FROM scholarship_requirements
		WHERE ScholarshipName = ?
		AND AwardAmount = ?
		AND Requirement = ?
		AND Weight != 0
	");
	$this->stmt->bind_param("sis",$scholar,$award,$req);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($scholarship);
	while($this->stmt->fetch()){
		$results[]=$scholarship;
	}
	if(count($results) != 0) {
		return 1;
	}
	else {
		return 0;
	}
}

function scholarshipMetPref($scholar,$award,$pref){
	$this->stmt = $this->connection->prepare("
		SELECT Weight
		FROM scholarship_preferences
		WHERE ScholarshipName = ?
		AND AwardAmount = ?
		AND Preference = ?
	");
	$this->stmt->bind_param("sis",$scholar,$award,$pref);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($weight);
	while($this->stmt->fetch()){
		$results[]=$weight;
	}
	if(count($results) != 0) {
		return $results;
	}
	else {
		return FALSE;
	}
}

function scholarshipMetOrReq($scholar,$award,$req){
	$this->stmt = $this->connection->prepare("
		SELECT ScholarshipName
		FROM scholarship_requirements
		WHERE ScholarshipName = ?
		AND AwardAmount = ?
		AND Requirement = ?
		AND Weight = 0
	");
	$this->stmt->bind_param("sis",$scholar,$award,$req);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($scholarship);
	while($this->stmt->fetch()){
		$results[]=$scholarship;
	}
	if(count($results) != 0) {
		return 1;
	}
	else {
		return 0;
	}
}

function getStuRef($ufid) {
	$this->stmt = $this->connection->prepare("
		SELECT Reference, referrer.name, referrer.email
		FROM student_referer_list
		JOIN referrer ON student_referer_list.Reference = referrer.username
		WHERE student_referer_list.student = ?
	");
	$this->stmt->bind_param("s",$ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($id, $name, $email);
	for($i=0;$this->stmt->fetch();$i++){
		$results[$i]["ufid"] = $id;
		$results[$i]["name"] = $name;
		$results[$i]["email"] = $email;
	}
	if(count($results) != 0) {
		return $results;
	}
	else {
		return 0;
	}
}

function checkRef($ref) {
	$this->stmt = $this->connection->prepare("
		SELECT count(Reference)
		FROM student_referer_list
		WHERE Reference = ?
	");
	$this->stmt->bind_param("s",$ref);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($referer);
	$this->stmt->fetch();
	if(1+1 == 2) {
		return $referer;
	}
	else {
		return 0;
	}
}

function deleteRef($stu,$ref) {
	$this->stmt = $this->connection->prepare("
		DELETE FROM student_referer_list
		WHERE Student = ?
		AND Reference = ?
	");
	$this->stmt->bind_param("ss",$stu,$ref);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows >= 1) {
		return TRUE;
	}
	else {
		return 0;
	}
}

function insertRef($stu,$ref) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO student_referer_list (Student,Reference)
		VALUES (?,?)
	");
	$this->stmt->bind_param("ss",$stu,$ref);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows >= 1) {
		return TRUE;
	}
	else {
		return 0;
	}
}

/********************************************************************/
function insertStudentScore($ufid,$name,$item ,$score){
	$this->stmt =$this->connection->prepare("
		SELECT committeeMember 
		FROM committee_item_score 
		WHERE committeeMember=?
		AND student=?
		AND item=?
	");
	$this->stmt->bind_param("sss",$ufid,$name,$item);
	$this->stmt->execute();
	$this->stmt->bind_result($cm);
	$this->stmt->store_result();
	$this->stmt->fetch();
	if(!isset($cm)){
		$this->stmt =$this->connection->prepare("
			INSERT INTO committee_item_score VALUES(?,?,?,?)
		");
		if(!$this->stmt) {
			die("updateStudentScore stmt failed");
		}
		$this->stmt->bind_param("ssss",$ufid,$name,$item,$score);
	}
	else {
		$this->stmt =$this->connection->prepare("
			UPDATE committee_item_score 
			SET score=?
			WHERE committeeMember=?
			AND student=?
			AND item=?
		");
		if(!$this->stmt) {
			die("updateStudentScore stmt failed");
		}
		$this->stmt->bind_param("ssss",$score,$ufid,$name,$item);
	}
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows==1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function getStuExtraMaterial($student){
	$this->stmt = $this->connection->prepare("
		SELECT Essay,Transcript,Resume
		FROM student_extra_materials
		WHERE student = ?
	");
	$this->stmt->bind_param("s",$student);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($essay,$transcript,$resume);
	while($this->stmt->fetch()){
		$results["essay"]=purgeoutput($essay);
		$results["transcript"]=purgeoutput($transcript);
		$results["resume"]=purgeoutput($resume);
	}
	if(count($results) != 0) {
		return $results;
	}
	else {
		return FALSE;
	}
}

function getStuExtraMaterialForRecc($student,$comment){
	$this->stmt = $this->connection->prepare("
		SELECT score
		FROM recommendations
		WHERE student = ? AND item=?
	");
	$this->stmt->bind_param("ss",$student,$comment);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($comments);
	while($this->stmt->fetch()){
		//$results["overall"]=$essay;
		$results[]=$comments	;
		
	}
	if(count($results) != 0) {
		return $results;
	}
	else {
		return FALSE;
	}
}


/********************************************************************/

function schAddReqOption($scholarship,$award,$requirement) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO scholarship_requirements (ScholarshipName,AwardAmount,Requirement,Weight)
		VALUES (?,?,?,0)
	");
	$this->stmt->bind_param("sss",$scholarship,$award,$requirement);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows >= 1) {
		return TRUE;
	}
	else {
		return 0;
	}
}

function schAddReq($scholarship,$award,$requirement) {
	$this->stmt = $this->connection->prepare("
		SELECT weight 
		FROM scholarship_requirements
		WHERE ScholarshipName=? AND AwardAmount=?
	");
	$this->stmt->bind_param("ss",$scholarship,$award);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($weight);
	$flag = $this->stmt->fetch();
	if($flag){
		/*$this->stmt = $this->connection->prepare("
			DROP TABLE IF EXISTS transitional;
			CREATE TABLE transitional(
				weight int(11)
			);

			INSERT INTO transitional (weight) VALUES 
			(
				(SELECT max(weight)+1 
				FROM scholarship_requirements 
				WHERE ScholarshipName=? AND AwardAmount=?)
			);

			INSERT INTO scholarship_requirements (ScholarshipName,AwardAmount,Requirement,Weight) 
			VALUES (?,?,?,(SELECT weight FROM transitional));

			DROP TABLE transitional;
		");*/
		$stmt1 = $this->connection->prepare("
			DROP TABLE IF EXISTS transitional;
		");
		$stmt1->execute();
		$stmt1->store_result();
		$stmt2 = $this->connection->prepare("
			CREATE TABLE transitional(
				weight int(11)
			);
		");
		$stmt2->execute();
		$stmt2->store_result();
		$stmt3 = $this->connection->prepare("
			INSERT INTO transitional (weight) VALUES 
			(
				(SELECT max(weight)+1 
				FROM scholarship_requirements 
				WHERE ScholarshipName=? AND AwardAmount=?)
			);
		");
		$stmt3->bind_param("si",$scholarship,$award);
		$stmt3->execute();
		$stmt3->store_result();
		$stmt4 = $this->connection->prepare("
			INSERT INTO scholarship_requirements (ScholarshipName,AwardAmount,Requirement,Weight) 
			VALUES (?,?,?,(SELECT weight FROM transitional));
		");
		$stmt4->bind_param("sis",$scholarship,$award,$requirement);
		$stmt4->execute();
		$stmt4->store_result();
		$stmt5 = $this->connection->prepare("
			DROP TABLE transitional;
		");
		$stmt5->execute();
		$stmt5->store_result();
		$stmt1->free_result();
		$stmt2->free_result();
		$stmt3->free_result();
		$stmt4->free_result();
		$stmt5->free_result();
		$stmt1->close();
		$stmt2->close();
		$stmt3->close();
		$stmt4->close();
		$stmt5->close();
	}
	else {
		$this->stmt = $this->connection->prepare("
			INSERT INTO scholarship_requirements (ScholarshipName,AwardAmount,Requirement,Weight)
			VALUES (?,?,?,1)
		");
		$this->stmt->bind_param("sss",$scholarship,$award,$requirement);
		$this->stmt->execute();
		$this->stmt->store_result();
	}
	
	if($this->stmt->affected_rows >= 1) {
		return TRUE;
	}
	else {
		return 0;
	}
}

function pickEligibles() {
	$this->stmt = $this->connection->prepare("
			DROP TABLE IF EXISTS temp_eligible;
		");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
			CREATE TABLE temp_eligible(
				ScholarshipName varchar(128),
				AwardAmount int(11),
				Student varchar(128)
			);
		");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		INSERT INTO temp_eligible 
		(ScholarshipName,AwardAmount,Student)
		
		SELECT DISTINCT desu1.name,desu1.amount,desu1.stu
		FROM(
			(SELECT 
				scholarship_requirements.ScholarshipName AS name, 
				scholarship_requirements.AwardAmount AS amount ,
				student_requirements.Student AS stu ,
				COUNT(DISTINCT scholarship_requirements.Weight) AS count
			FROM scholarship_requirements
			JOIN student_requirements
			ON scholarship_requirements.Requirement=student_requirements.Requirement
			GROUP BY name,amount,stu
		) AS desu1
		JOIN (
			SELECT 
				ScholarshipName AS name, 
				AwardAmount AS amount ,
				COUNT(DISTINCT Weight) AS count
			FROM scholarship_requirements
			GROUP BY name,amount
		) AS desu2
		ON desu1.name=desu2.name AND desu1.amount=desu2.amount AND desu1.count=desu2.count
		)
		GROUP BY desu1.name,desu1.amount,desu1.stu
		
	");
	//$this->stmt->bind_param("sss",$scholarship,$award,$requirement);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows >= 1) {
		return TRUE;
	}
	else {
		return 0;
	}
}

function checkSchWithReq($ScholarshipName,$AwardAmount) {
	$this->stmt = $this->connection->prepare("
		SELECT ScholarshipName,AwardAmount
		FROM scholarship_requirements
		WHERE ScholarshipName=? AND AwardAmount=?
	");
	$this->stmt->bind_param("si",$ScholarshipName,$AwardAmount);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($sch,$amount);
	$this->stmt->fetch();
	$result = $sch;
	/*$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["scholarship"] = $sch;
		$result[$i]["amount"] = $amount;
	}*/
	if(isset($result)) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function addEligible($ScholarshipName,$AwardAmount,$Student) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO temp_eligible 
		(ScholarshipName,AwardAmount,Student)
		VALUES(?,?,?)
	");
	$this->stmt->bind_param("sis",$ScholarshipName,$AwardAmount,$Student);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows >= 1) {
		return TRUE;
	}
	else {
		return 0;
	}
}

function getEligible($ScholarshipName=NULL,$AwardAmount=NULL,$Student=NULL) {
	if($ScholarshipName == NULL && $AwardAmount==NULL && $Student==NULL){
		$this->stmt = $this->connection->prepare("
			SELECT ScholarshipName,AwardAmount,Student 
			FROM temp_eligible 
		");
	}
	else if($Student==NULL) {
		$this->stmt = $this->connection->prepare("
			SELECT ScholarshipName,AwardAmount,Student 
			FROM temp_eligible 
			WHERE ScholarshipName=? 
			AND AwardAmount=?
		");
		$this->stmt->bind_param("si",$ScholarshipName,$AwardAmount);
	}
	else {
		$this->stmt = $this->connection->prepare("
			SELECT ScholarshipName,AwardAmount,Student 
			FROM temp_eligible 
			WHERE Student=?
		");
		$this->stmt->bind_param("s",$Student);
	}
	//$this->stmt->bind_param("sis",$ScholarshipName,$AwardAmount,$Student);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($ScholarshipName,$AwardAmount,$Student);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["ScholarshipName"] = $ScholarshipName;
		$result[$i]["AwardAmount"] = $AwardAmount;
		$result[$i]["Student"] = $Student;
	}
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function getApp($ScholarshipName=NULL,$AwardAmount=NULL,$Student=NULL) {
	if($ScholarshipName == NULL && $AwardAmount==NULL && $Student==NULL){
		$this->stmt = $this->connection->prepare("
			SELECT DISTINCT ScholarshipName,AwardAmount,Student 
			FROM temp_app 
		");
	}
	else if($Student==NULL) {
		$this->stmt = $this->connection->prepare("
			SELECT DISTINCT ScholarshipName,AwardAmount,Student 
			FROM temp_app 
			WHERE ScholarshipName=? 
			AND AwardAmount=?
		");
		$this->stmt->bind_param("si",$ScholarshipName,$AwardAmount);
	}
	else {
		$this->stmt = $this->connection->prepare("
			SELECT DISTINCT ScholarshipName,AwardAmount,Student 
			FROM temp_app 
			WHERE Student=?
		");
		$this->stmt->bind_param("s",$Student);
	}
	//$this->stmt->bind_param("sis",$ScholarshipName,$AwardAmount,$Student);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($ScholarshipName,$AwardAmount,$Student);
	$result = array();
	for($i=0;$this->stmt->fetch();$i++) {
		$result[$i]["ScholarshipName"] = $ScholarshipName;
		$result[$i]["AwardAmount"] = $AwardAmount;
		$result[$i]["Student"] = $Student;
	}
	if(count($result)!=0) {
		return $result;
	}
	else {
		return FALSE;
	}
}

function setBouns() {
	$this->stmt = $this->connection->prepare("
		DROP TABLE IF EXISTS temp_bouns;
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		CREATE TABLE temp_bouns(
			ScholarshipName varchar(128),
			AwardAmount int(11),
			Student varchar(128),
			Weight int(11)
		);
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		INSERT INTO temp_bouns 
		(ScholarshipName,AwardAmount,Student,Weight)
		
		SELECT scholarship_preferences.ScholarshipName,scholarship_preferences.AwardAmount,student_requirements.Student,scholarship_preferences.Weight
		FROM scholarship_preferences
		JOIN student_requirements
		ON scholarship_preferences.Preference=student_requirements.Requirement
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows >= 1) {
		return TRUE;
	}
	else {
		return 0;
	}
}

function getBouns($ScholarshipName,$AwardAmount,$Student) {
	$this->stmt = $this->connection->prepare("
		SELECT sum(Weight) 
		FROM temp_bouns
		WHERE  ScholarshipName=?
		AND AwardAmount=?
		AND Student=?
	");
	$this->stmt->bind_param("sis",$ScholarshipName,$AwardAmount,$Student);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($score);
	$this->stmt->fetch();
	if(isset($score)) {
		return $score;
	}
	else {
		return FALSE;
	}
}

function getComScore($stu) {
	$this->stmt = $this->connection->prepare("
		SELECT sum(score)
		FROM committee_item_score 
		WHERE student=?
	");
	$this->stmt->bind_param("s",$stu);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($score);
	$this->stmt->fetch();
	if(isset($score)) {
		return $score;
	}
	else {
		return FALSE;
	}
}

function getRefScore($stu) {
	$this->stmt = $this->connection->prepare("
		SELECT sum(score)
		FROM recommendations 
		WHERE student=?
	");
	$this->stmt->bind_param("s",$stu);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($score);
	$this->stmt->fetch();
	if(isset($score)) {
		return $score;
	}
	else {
		return FALSE;
	}
}

function assignScholarship($ScholarshipName,$AwardAmount,$Student) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO student_scholarship 
		(ScholarshipName,AwardAmount,Student)
		VALUES(?,?,?)
	");
	$this->stmt->bind_param("sis",$ScholarshipName,$AwardAmount,$Student);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows >= 1) {
		return TRUE;
	}
	else {
		return 0;
	}
}

function deleteWinner($scholar,$student,$amount){
	$this->stmt = $this->connection->prepare("
		DELETE FROM winners
		WHERE student=?
		AND scholarship=?
		AND amount=?
	");
	$this->stmt->bind_param("ssi",$student,$scholar,$amount);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows>=1) {
		return TRUE;
	}else{
		return FALSE;
	}
}

function noWinningStudents($schol,$amount){
	$this->stmt = $this->connection->prepare("
		SELECT students.name, students.ufid
		FROM students
		LEFT JOIN (
		SELECT scholarship, student
		FROM winners
		WHERE scholarship=?
		AND amount=?) AS winnerSc ON winnerSc.student = students.ufid
		WHERE (winnerSC.scholarship IS NULL	)
	");
	$this->stmt->bind_param("si",$schol,$amount);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($studentName,$studentID);
	for($i=0;$this->stmt->fetch();$i++) {
		$results[$i]["ufid"] = $studentID;
		$results[$i]["name"]= $studentName;
	}
	if(count($results) != 0) {
		return $results;
	}else {
		return FALSE;
	}
}

function clearWinners(){
	$this->stmt = $this->connection->prepare("
		DELETE FROM winners
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows>=1) {
		return TRUE;
	}else{
		return FALSE;
	}
}

function assignWinner($scholar,$amount,$student){
	$this->stmt = $this->connection->prepare("
		INSERT INTO winners (scholarship,amount,student)
		VALUES (?,?,?)
	");
	$this->stmt->bind_param("sis",$scholar,$amount,$student);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows>=1) {
		return TRUE;
	}else{
		return FALSE;
	}
}

function getWinners($scholarship,$amount){
	$this->stmt = $this->connection->prepare("
		SELECT ufid, students.name
		FROM Winners
		JOIN students ON students.ufid = winners.student
		WHERE scholarship=?
		AND amount=?
	");
	$this->stmt->bind_param("si",$scholarship,$amount);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($studentID, $studentName);
	for($i=0;$this->stmt->fetch();$i++) {
		$results[$i]["ufid"] = $studentID;
		$results[$i]["name"]= $studentName;
	}
	if(count($results) != 0) {
		return $results;
	}else {
		return FALSE;
	}
}

function getWinnersCount(){
	$this->stmt = $this->connection->prepare("
		SELECT student, students.name, count(scholarship)
		FROM winners
		JOIN students ON students.ufid = winners.student
		GROUP BY student
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($studentID,$studentName,$count);
	for($i=0;$this->stmt->fetch();$i++) {
		$results[$i]["ufid"] = $studentID;
		$results[$i]["name"]= $studentName;
		$results[$i]["count"]=$count;
	}
	if(count($results) != 0) {
		return $results;
	}else {
		return FALSE;
	}
}

function checkReferExist($email){
	$this->stmt = $this->connection->prepare("
		SELECT username
		FROM referrer
		WHERE email=?
	");
	$this->stmt->bind_param("s",$email);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($username);
	$this->stmt->fetch();
	if(isset($username)) {
		return $username;
	}
	else {
		return FALSE;
	}
}

function addReferrer($username,$name,$email){
	$this->stmt = $this->connection->prepare("
		INSERT INTO referrer (username, name, email)
		VALUES (?,?,?)
	");
	$this->stmt->bind_param("sss",$username,$name,$email);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows>=1) {
		return TRUE;
	}else{
		return FALSE;
	}
}

function addStudentReferer($student,$referrer){
	$this->stmt = $this->connection->prepare("
		INSERT INTO student_referer_list (student, reference, complete)
		VALUES (?,?,0)
	");
	$this->stmt->bind_param("ss",$student,$referrer);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows>=1) {
		return TRUE;
	}else{
		return FALSE;
	}
}

function clearReferences($student){
	$this->stmt = $this->connection->prepare("
		DELETE FROM student_referer_list 
		WHERE student=?
	");
	$this->stmt->bind_param("s",$student);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows>=1) {
		return TRUE;
	}else{
		return FALSE;
	}
}

function getScoreCriteria($item){
	$this->stmt = $this->connection->prepare("
		SELECT score, comment
		FROM com_score
		WHERE title=?
		ORDER BY score DESC
	");
	$this->stmt->bind_param("s",$item);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($score,$criteria);
	for($i=0;$this->stmt->fetch();$i++) {
		$results[$i]["score"] = $score;
		$results[$i]["crit"]= $criteria;
	}
	if(count($results) != 0) {
		return $results;
	}else {
		return FALSE;
	}	
}


function getStudentGRE($student){
	$this->stmt = $this->connection->prepare("
		SELECT GRE_SAT_ACT
		FROM students
		WHERE ufid=?
	");
	$this->stmt->bind_param("s",$student);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($gre);
	$this->stmt->fetch();
	if(isset($gre)) {
		return $gre;
	}
	else {
		return FALSE;
	}
}

function getRefForStudent($student,$rec,$item){
	$this->stmt = $this->connection->prepare("
		SELECT score
		FROM recommendations
		WHERE recommender=?
		AND student=?
		AND item=?
	");
	$this->stmt->bind_param("sss",$rec,$student,$item);
	$this->stmt->execute();
	$this->stmt->store_result();
	$results = array();
	$this->stmt->bind_result($score);
	$this->stmt->fetch();
	if(isset($score)) {
		return $score;
	}else {
		return FALSE;
	}
}

function newStudCommScore($student,$comm,$item,$score){
	$this->stmt = $this->connection->prepare("
		INSERT INTO committee_item_score
		VALUES (?,?,?,?)
	");
	$this->stmt->bind_param("sssi",$comm,$student,$item,$score);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows>=1) {
		return TRUE;
	}else{
		return FALSE;
	}
}

function clearStudCommScore($student,$comm,$item){
	$this->stmt = $this->connection->prepare("
		DELETE FROM committee_item_score
		WHERE committeeMember=?
		AND student=?
		AND item=?
	");
	$this->stmt->bind_param("sss",$comm,$student,$item);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows>=1) {
		return TRUE;
	}else{
		return FALSE;
	}
}

function removeSchReq($ScholarshipName,$AwardAmount,$Requirement) {
	$this->stmt = $this->connection->prepare("
		DROP TABLE IF EXISTS transitional;
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		CREATE TABLE transitional(
			Weight int(11)
		);
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		INSERT INTO transitional
		SELECT Weight
		FROM scholarship_requirements
		WHERE ScholarshipName=?
		AND AwardAmount=?
		AND Requirement=?
	");
	$this->stmt->bind_param("sis",$ScholarshipName,$AwardAmount,$Requirement);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		SELECT Weight
		FROM transitional
		LIMIT 1;
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($wieght);
	$this->stmt->fetch();
	if($wieght) {
		$this->stmt = $this->connection->prepare("
			UPDATE scholarship_requirements
			SET Weight=(Weight-1)
			WHERE Weight>(
				SELECT Weight
				FROM transitional
				LIMIT 1
			);
		");
		$this->stmt->execute();
		$this->stmt->store_result();
	}
	$this->stmt = $this->connection->prepare("
		DELETE FROM scholarship_requirements
		WHERE ScholarshipName=?
		AND AwardAmount=?
		AND Requirement=?
	");
	$this->stmt->bind_param("sis",$ScholarshipName,$AwardAmount,$Requirement);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		DROP TABLE transitional;
	");
	$this->stmt->execute();
	$this->stmt->store_result();

}

function checkStudentSchChecked($ufid,$scholar,$amount){
	$this->stmt =$this->connection->prepare("
		SELECT student
		FROM student_scholarship
		WHERE Student=?		
		AND ScholarshipName=?
		AND AwardAmount=?
	");
	if(!$this->stmt) {
		die("checkStudentSchChecked stmt failed");
	}
	$this->stmt->bind_param("sss", $ufid,$scholar,$amount);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($name);
	while($this->stmt->fetch()){
		$output[]=$name;
	}
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function getStuApplied() {
	$this->stmt = $this->connection->prepare("
		DROP TABLE IF EXISTS temp_app;
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		CREATE TABLE temp_app(
			ScholarshipName varchar(128),
			AwardAmount int(11),
			Student varchar(128)
		);
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		INSERT INTO temp_app 
		SELECT ScholarshipName,AwardAmount,Student
		FROM temp_eligible 
		WHERE Exists (
			SELECT ScholarshipName,AwardAmount,Student
			FROM student_scholarship
			WHERE student_scholarship.ScholarshipName=temp_eligible.ScholarshipName
			AND student_scholarship.Student=temp_eligible.Student
			AND student_scholarship.AwardAmount=temp_eligible.AwardAmount
		);
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		SELECT ScholarshipName,AwardAmount,Student
		FROM temp_app
	");
	if(!$this->stmt) {
		die("checkStudentSchChecked stmt failed");
	}
	//$this->stmt->bind_param("sis",$ScholarshipName,$AwardAmount,$Student);
	$this->stmt->execute();
	$this->stmt->store_result();
	$output = array();
	$this->stmt->bind_result($ScholarshipName,$AwardAmount,$Student);
	for($i=0;$this->stmt->fetch();$i++){
		$output[$i]["ScholarshipName"]=$ScholarshipName;
		$output[$i]["AwardAmount"]=$AwardAmount;
		$output[$i]["Student"]=$Student;
	}
	/*$this->stmt = $this->connection->prepare("
		DROP TABLE IF EXISTS transitional;
	");*/
	if(count($output) != 0) {
		return $output;
	}
	else {
		return FALSE;
	}
}

function dropTemps() {
	$this->stmt = $this->connection->prepare("
		DROP TABLE IF EXISTS temp_eligible;
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		DROP TABLE IF EXISTS temp_bouns;
	");
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt = $this->connection->prepare("
		DROP TABLE IF EXISTS temp_app;
	");
	$this->stmt->execute();
	$this->stmt->store_result();
}

function addBan($ip) {
	$this->stmt = $this->connection->prepare("
		INSERT INTO banlist 
		VALUES (?)
	");
	$this->stmt->bind_param("s",$ip);
	$this->stmt->execute();
	$this->stmt->store_result();
}

function checkBan($ip) {
	$this->stmt = $this->connection->prepare("
		SELECT count(ip)
		FROM banlist 
		WHERE ip=?
	");
	$this->stmt->bind_param("s",$ip);
	$this->stmt->execute();
	$this->stmt->store_result();
	$this->stmt->bind_result($count);
	$this->stmt->fetch();
	if(isset($count))
	return $count;
	else return false;
}

function addStudentAppSch($ufid,$scholar,$amount){
	 	        $this->stmt =$this->connection->prepare("
	 	                INSERT INTO student_scholarship
	 	                VALUES(?,?,?)
	 	        ");
	 	        if(!$this->stmt) {
	 	                die("addStudentAppSch stmt failed");
	 	        }
	 	        $this->stmt->bind_param("sss",$ufid,$scholar,$amount);
	 	        $this->stmt->execute();
	 	        $this->stmt->store_result();
	 	        if($this->stmt->affected_rows==1) {
	 	                return TRUE;
	 	        }
	 	        else {
	 	                return FALSE;
	 	        }
	 	}

		
function deleteAllStudAppSch($ufid){
	$this->stmt =$this->connection->prepare("
		DELETE
		FROM student_scholarship
		WHERE student=?
	");
	if(!$this->stmt) {
		die("deleteAllStudAppSch stmt failed");
	}
	$this->stmt->bind_param("s", $ufid);
	$this->stmt->execute();
	$this->stmt->store_result();
	if($this->stmt->affected_rows >= 1) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

}



$database = new database();
?>