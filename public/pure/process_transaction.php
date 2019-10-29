<?php
$merchantSessionKey = $_POST["merchantSessionKey"];
$cardIdentifier = $_POST["card-identifier"];

$amount = $_POST["amount"];
$currency = $_POST["currency"];

$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];

$billing_address = $_POST["billing_address"];
$billing_city = $_POST["billing_city"];
$billing_zip = $_POST["billing_zip"];
$billing_country = $_POST["billing_country"];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://pi-test.sagepay.com/api/v1/transactions",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => '{' .
    '"transactionType": "Payment",' .
    '"paymentMethod": {' .
    '    "card": {' .
    '        "merchantSessionKey": "' . $merchantSessionKey . '",' .
    '        "cardIdentifier": "' . $cardIdentifier . '"' .
    '    }' .
    '},' .
    '"vendorTxCode": "SagePayExample' . time() . '",' .
    '"amount": ' . $amount . ',' .
    '"currency": "' . $currency . '",' .
    '"description": "Sage Payment Integration Example",' .
    '"apply3DSecure": "UseMSPSetting",' .
    '"customerFirstName": "' . $firstName . '",' .
    '"customerLastName": "' . $lastName . '",' .
    '"billingAddress": {' .
    '    "address1": "' . $billing_address . '",' .
    '    "city": "' . $billing_city . '",' .
    '    "postalCode": "' . $billing_zip . '",' .
    '    "country": "' . $billing_country . '"' .
    '},' .
    '"entryMethod": "Ecommerce"' .
    '}',
    CURLOPT_HTTPHEADER => array(
        "Authorization: BASIC_AUTHORIZATION_CODE",
        "Cache-Control: no-cache",
        "Content-Type: application/json"
    ),
));

$response = curl_exec($curl);
$result = json_decode($response);
$err = curl_error($curl);

curl_close($curl);
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" / >
</head>
<body>
<?php if(!empty($result->status) && $result->status == "Ok") { ?>
<div id="response-container" class="success">
    <div class="img-response"><img src="success.png" /></div>
    <div class="ack-message">Thank You!</div>
    <div>Sage Payment is Completed.</div>
</div>
<?php } else {?>
<div id="response-container" class="error">
    <div class="img-response"><img src="error.png" /></div>
    <div class="ack-message">Payment Failed!</div>
    <div>Problem in Processing Sage Payment. </div>
</div>
<?php  } ?>
</body>
</html>