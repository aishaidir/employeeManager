<?php

/**
 * @param $algorithm e.g. "sha1", "sha256"
 * @param $str: String to hash
 * @param $key: Key value to hash with string
 */

$clientId = "testclient";
$deviceId = "11111122222";
$meterNo = "411111111990";
$dateTime = "2016-12-26 12:37";
$hash = hash("sha256", $clientId.$deviceId.$dateTime);

//echo $hash;


function hashString($algorithm, $str, $key) {

	$hash_str = hash_hmac($algorithm, $str, $key);

	return bin2hex($hash_str);

}

echo hashString("sha256", $hash, $meterNo);

?>