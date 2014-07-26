<?php
require_once("init.php");
//list all the stuff in a table
function display4edit($columns,$table,$key,$submitvalue = "manipulate",$value = NULL) {
	global $database;
	//if (isset($value)) die(json_encode($value));
	$result = $database->geteverything($columns, $table, $key,$value);
	
	$ccount = count($result);
	$rcount = count($result[0]);
	echo "<table>";
	if(isset($columns["key"])){
		echo "<tr>";
		echo "<th>";
			echo $columns["key"];
		echo "</th>";
		for($j=0;$j<$ccount-1;$j++) {
			echo "<th>";
			echo $columns[$j];
			echo "</th>";
		}
		echo "</tr>";
	}
	else {
		echo "<tr>";
		for($j=0;$j<$ccount;$j++) {
			echo "<th>";
			echo $columns[$j];
			echo "</th>";
		}
		echo "</tr>";
	}
	for($i=0;$i<$rcount;$i++) {
		echo "<tr>";
			for($j=0;$j<$ccount;$j++) {
				echo "<td>";
				echo $result[$j][$i];
				echo "</td>";
			}
			echo "<td>";
			echo "<input type=\"submit\" name=".$result[0][$i]." value='".$submitvalue."'>";
			echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
}

//the real dispaly for an edit page
function REALdisplay4edit($colums,$silverkey,$table,$page) {
	global $database;
	echo "<form action=".$page." method=\"POST\">";
	//die($page);
	if($page!="useredit.php") {
		//die("good");
		foreach($colums as $colum) {
			echo $colum.": ";
			//$pk = array();
			echo "<input type=\"text\" name=".$colum." autocomplete=\"off\" value='".$database->getelementfromrow($colum,$silverkey,$table,$colums["key"])."' />";
			//die($colum.$silverkey.$table.$colums["key"]);
			echo "<br/>";
		}
	}
	else {
		foreach($colums as $colum) {
			echo $colum.": ";
			//$pk = array();
			echo "<input type=\"text\" name=".$colum." autocomplete=\"off\" value='".$database->getelementfromrow($colum,$silverkey,$table,$colums["key"])."' />";
			echo "<br/>";
		}
		$pass = $database->getpassword($silverkey);
		//die($pass);
		echo "password : ";
		echo "<input type=\"text\" name='password' autocomplete=\"off\" value='".$pass."' />";
		echo "<br/>";
	}
	echo "<input type=\"submit\" name=\"delete\" value=\"delete\">";
	echo "<input type=\"submit\" name=\"update\" value=\"update\">";
	echo "<input type=\"submit\" name=\"add\" value=\"add\">";
	echo "</form>";
}

//used in a score page
function scorecon() {
	global $result;
	global $i;
	
}

//what's in a scoring page
function display4score($result,$parent) {
//	$result;
	echo "<form action='".$parent."' method=\"POST\">";
	$flag = $result[0][0];
	echo $flag;
	for($i=0;$result[0][$i] == $flag;$i++) {
		echo "<div>";
		echo $result[2][$i];
		echo "<br/>";
		echo "<input type=\"radio\" name='".$flag."' value='".$result[1][$i]."'>".$result[1][$i]."</input>";
		echo "</div>";
	}
	while($i!=0){
		echo "<hr/>";
		$flag = $result[0][$i+1];
		$combo = $i;
		echo $flag;
		for($i=$combo;$result[0][$i] == $flag;$i++) {
			echo "<div>";
			echo $result[2][$i];
			echo "<br/>";
			echo "<input type=\"radio\" name='".$flag."' value='".$result[1][$i]."'>".$result[1][$i]."</input>";
			echo "</div>";
			if (!isset($result[0][$i+1])) {
				$i=0;
				break;
			}
		}
	}
	echo "<input type=\"submit\" name=\"submit1\" value=\"Submit\">";
	echo "</form>";
}

//header of an <del>hero</del> edit page
function editheader($colums,$table,$parent) {
	global $database;
	global $silverkey;
	if(isset($_POST)) {
		if(isset($_POST["delete"])) {
			$key = $colums["key"];
			$database->deletrows($key,$_POST[$key],$table);
			redirect($parent);
		}
		else if(isset($_POST["update"])) {
			if($parent!="user.php") {
				$key = $colums["key"];
				foreach($colums as $colum) {
					$value = $_POST[$colum];
					$database->updatecolum($_POST[$key],$value,$table,$colum,$key);
				}
				$silverkey = $_POST[$key];
		}
		else {
			$key = $colums["key"];
			$database->deletrows($key,$_POST[$key],$table);
			$database->insertuser($_POST["ufid"],$_POST["class"],$_POST["password"]);
			$silverkey = $_POST[$key];
			}
		}
		else if(isset($_POST["add"])) {
			if($parent!="user.php") {
				$key = $colums["key"];
				$values = array();
				foreach($colums as $colum) {
					$value = $_POST[$colum];
					array_push($values,$value);
				}
				$database->insertrow($values,$table,$colums);
				$silverkey = $_POST[$key];
			}
			else {
				$key = $colums["key"];
				$database->insertuser($_POST["ufid"],$_POST["class"],$_POST["password"]);
				$silverkey = $_POST[$key];
			}
		}
		else {
			$silverkey = NULL;
			foreach($_POST as $faggot => $noonecares){
				$silverkey = $faggot;
			}
			if(!$silverkey) {
				redirect($parent);
			}
		}
	}
	else {
		redirect($parent);
	}
}
?>