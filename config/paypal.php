<?php

require 'vendor/autoload.php';

define('PAYPAL_CLIENT_ID', 'your-client-id');
define('PAYPAL_CLIENT_SECRET', 'your-client-secret');
define('PAYPAL_MODE', 'sandbox'); // or 'live'

$paypal = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        PAYPAL_CLIENT_ID,
        PAYPAL_CLIENT_SECRET
    )
);

$paypal->setConfig([
    'mode' => PAYPAL_MODE
]);
?>
