<?php
$variables = array("x1" => 0, "x2" =>1);
$objective = array("x1" => 1, "x2" => 2 );
$constraint1 = array("x1" => 1,"x2" => 1, "ub" => 40);
$constraint2 = array("x1" => 2,"x2" => 1, "ub" => 60);
$constraints = array(1 => $constraint1, 2 => $constraint2 );
$optimization = "<osil>
	<instanceHeader>
		<name>cheerilee.osil</name>
		<source>backup</source>
		<description></description>
	</instanceHeader>
	<instanceData>\n";
$handle = fopen("c:\\wamp\\www\\derp\\backup\\loovemecheerilee.osil", "w");
writecloseunset();

$optimization = "		<variables numberOfVariables= '".count($variables)."' >\n";
foreach($variables as $name => $index) {
	$optimization .= " 			<var name='".$name."' />\n";
}
$optimization .= " 		</variables>\n";
addbinary();

$optimization .= "		<objectives>\n";
$optimization .= "			<obj maxOrMin='max' numberOfObjCoef='".count($objective)."'>\n";
foreach($objective as $name => $value) {
	$optimization .= "				<coef idx='".$variables[$name]."'>".$value."</coef>\n";
}
$optimization .= "			</obj>
		</objectives>\n";
addbinary();



function addbinary() {
	global $handle;
	$handle = fopen("c:\\wamp\\www\\derp\\backup\\loovemecheerilee.osil", "a");
	writecloseunset();
}

function writecloseunset() {
	global $handle;
	global $optimization;
	fwrite($handle,$optimization);
	fclose($handle);
	unset($optimization);
}
?>