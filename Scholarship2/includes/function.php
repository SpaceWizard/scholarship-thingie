<?php require_once("init.php"); ?>
<?php

function redirect($location) {
	header("Location: ".$location);
	exit;
}

function purgeoutput($unclean) {
	$unclean = strip_tags($unclean);
	$unclean = htmlentities($unclean);
	$unclean = htmlspecialchars($unclean);
//	$unclean = json_encode($unclean);
//	$heresy = array(":",";",".",",","IF","%","&","-","#","/","*","'",'"',"<",">"," ","0x","0X","\n","\r");
//	foreach($heresy as $heretic) {
//		$unclean = str_replace($heretic,"",$unclean);
//	}
//	$unclean = addslashes($unclean);
	$clean = $unclean;
	return $clean;
}

//lol not working, dunno how to defeat that ED thingy
function egencrypt($origin) {
	$result = hash("whirlpool",$origin);
	return $result;
}

function aesencrypt($origin) {

	$key = pack('H*', EN_PASS);

    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$plaintext_utf8 = utf8_encode($origin);
	$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext_utf8, MCRYPT_MODE_CBC, $iv);
	$ciphertext = $iv . $ciphertext;
	$ciphertext_base64 = base64_encode($ciphertext);
	$result = array("password" => $ciphertext_base64, "iv" => $iv_size);
	return $result;
}

function aesdecrypt($ciphertext,$iv_size) {
	$ciphertext_dec = base64_decode($ciphertext);

	$key = pack('H*',EN_PASS);
	$iv_dec = substr($ciphertext_dec, 0, $iv_size);

	$ciphertext_dec = substr($ciphertext_dec, $iv_size);

	$plaintext_utf8_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
	$plaintext_noninv = preg_replace('/\p{C}+/u','', $plaintext_utf8_dec);
	return $plaintext_noninv;
}

function addref($ref,$ufid,$email,$oldeRef=NULL) {
	global $database;
	$refNumber = $database->checkRef($ref);
	if($refNumber == 0 ) {
		$refpass = rand();
		if($oldeRef) {
			$database->deleteuser($oldeRef);
		}
		$database->insertuser($ref,"referer",$refpass);
		$database->addReferrer($ref,$ref,$email);
		mail($email, "you need to score your student ".$ufid," your username shall be ".$ref.", your password shall be ".$refpass);
	}
	else {
		//$refpass = rand();
		if($oldeRef) {
			$database->deleteuser($oldeRef);
		}
		//$database->insertuser($ref,"referer",$refpass);
		mail($email, "you need to score your student ".$ufid," your username and password stays the same ");
	}
	$database->deleteRef($ufid,$oldeRef);
	$database->insertref($ufid,$ref);	
}

function getEligibleTable() {
	global $database;
	$database->pickEligiblees();
	$database->pickEligiblees();
}

?>