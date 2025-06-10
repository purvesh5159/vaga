<?php
echo '<title>Vaga Inc - Google Authendicator QR Code</title>';
require('./vendor/autoload.php');

$google2fa = new \PragmaRX\Google2FA\Google2FA();
      
// $text = $google2fa->getQRCodeUrl(
//  'example.com',
//  $username,
//  $secret_key
// );

$text = $google2fa->getQRCodeUrl(
    'vagainc.ca',
    'SecureAuthedication',
    'WU2N6ZAMYPSXPMWWBPQGFDHY43F7ZT55'
   );
 
//$image_url = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl='.$text;
$image_url = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=otpauth://totp/vagainc.ca:SecureAuthentication?secret=WU2N6ZAMYPSXPMWWBPQGFDHY43F7ZT55&issuer=vagainc.ca&algorithm=SHA1&digits=6&period=30';

echo $image_url;
echo '<center><h1>Google Authendicator QR Code</h1>';
echo '<h4>Install Google Authendicator from Google Play Store and scan</h1>';
echo '<img src="'.$image_url.'" />';
?>