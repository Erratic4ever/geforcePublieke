<?php
error_reporting(0);
session_start();

if(isset($_SERVER['HTTP_REFERER']) && isset($_SERVER['HTTP_HOST']) && isset($_SESSION['USER_OK']) && $_SESSION['USER_OK'] === 'OK' && isset($_SESSION['SESSION_ID'])) {
	$ref = $_SERVER['HTTP_REFERER'];
	$host = $_SERVER['HTTP_HOST'];

	if (strpos($ref, $host) !== FALSE) {
	$include = 1;
	include("inc/save.php");
	}
}


?>