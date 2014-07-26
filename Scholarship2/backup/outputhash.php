<?php
//echo hash("whirlpool","muffin");
//echo hash("whirlpool","twilight");
//echo json_encode("<script>alert(document.cookie);</script>");
//$lulz = "troll";
//echo json_encode($lulz);
//echo "<script>alert(document.cookie);</script>";
$key = md5("friendship_is_magic"); // pack('H*', "friendshipIsMagic");
$key = pack('H*', $key);
$key_size =  strlen($key);
$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
$plaintext_utf8 = utf8_encode("twilight");
$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext_utf8, MCRYPT_MODE_CBC, $iv);
$ciphertext = $iv . $ciphertext;
$ciphertext_base64 = base64_encode($ciphertext);
$ciphertext_dec = base64_decode($ciphertext_base64);
echo $ciphertext_dec;
echo "<br/>";
echo $iv_size;
echo "<br/>";
$iv_dec = substr($ciphertext_dec, 0, $iv_size);
$ciphertext_dec = substr($ciphertext_dec, $iv_size);
$plaintext_utf8_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
echo $plaintext_utf8_dec;


?>