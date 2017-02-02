<?php
	
	$DBhost = "172.45.20.164";
	$DBuser = "zabbixmon";
	$DBpass = "aeonvmc2014";
	$DBname = "AMY";
	
$conn = oci_connect($DBuser, $DBpass, "$DBhost/$DBname");
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
