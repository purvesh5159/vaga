<?php
require('./vendor/autoload.php');
$secret_key = 'WU2N6ZAMYPSXPMWWBPQGFDHY43F7ZT55';
$user_provided_code = '922402';
$google2fa = new \PragmaRX\Google2FA\Google2FA();
if ($google2fa->verifyKey($secret_key, $user_provided_code)) {
 
    echo "valid";
} else {
    echo "invalid";

}
?>