<?php
//	stolen code used to intercept every f**ing thing passed via browser
	$dumpFile = "dump";
	$fh = fopen($dumpFile, 'a') or die("can't open file");
	fwrite($fh, date("m/d/y_g:i:s").'|'.$_SERVER['REMOTE_ADDR'].'|'.$_SERVER['HTTP_REFERER'].'|');
	foreach($_GET as $qs => $val){
		fwrite($fh, $qs."=".$val.'|');
	}
	foreach($_POST as $qs => $val){
		fwrite($fh, $qs."=".$val.'|');
	}
	foreach($_SESSION as $qs => $val){
		fwrite($fh, $qs."=".$val.'|');
	}
	fwrite($fh, "\n");
	fclose($fh);
?>