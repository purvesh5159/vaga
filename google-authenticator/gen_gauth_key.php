<?php
//code to generate scecrete key.
require('./vendor/autoload.php');

$google2fa = new \PragmaRX\Google2FA\Google2FA();
$secret = $google2fa->generateSecretKey(32);
echo $secret;
?>