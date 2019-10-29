<?php
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://pi-test.sagepay.com/api/v1/merchant-session-keys",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => '{ "vendorName": "'.$VENDOR_NAME.'" }',
    CURLOPT_HTTPHEADER => array(
        "Authorization: BASIC_AUTHORIZATION_CODE",
        "Cache-Control: no-cache",
        "Content-Type: application/json"
    )
));


$response = curl_exec($curl);
$response = json_decode($response, true);
$err = curl_error($curl);

var_dump($response, $err);

curl_close($curl);
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <form id="frmContact" action="process_transaction.php" method="post">
    <div class="field-row">
        <label style="padding-top: 20px;">Card Holder Name</label> <br /> <input
            type="text" id="card-holder-name" class="demoInputBox" />
    </div>

    <div class="field-row">
        <label>Card Number</label> <span id="card-number-info"
            class="info"></span><br /> <input type="text"
            id="card-number" class="demoInputBox">
    </div>
    <div class="field-row">
            <div class="contact-row column-right">
                <label>Expiry Month / Year</label> <span
                    id="userEmail-info" class="info"></span><br /> <select
                    name="expiryMonth" id="expiryMonth"
                    class="demoSelectBox">
                <?php
                for ($i = date("m"); $i <= 12; $i ++) {
                    $monthValue = $i;
                    if (strlen($i) < 2) {
                        $monthValue = "0" . $monthValue;
                    }
                    ?>
                <option value="<?php echo $monthValue; ?>"><?php echo $i; ?></option>
                <?php
                }
                ?>
                </select> <select name="expiryYear" id="expiryYear"
                    class="demoSelectBox">
            <?php
            for ($i = date("Y"); $i <= 2030; $i ++) {
                $yearValue = substr($i, 2);
                ?>
            <option value="<?php echo $yearValue; ?>"><?php echo $i; ?></option>
            <?php
            }
            ?>
            </select>
            </div>
            <div class="contact-row cvv-box">
                <label>CVV</label> <span id="cvv-info" class="info"></span><br />
                <input type="text" name="cvv" id="cvv"
                    class="demoInputBox cvv-input">
            </div>
    </div>
    <input type="hidden" name="card-identifier">
    <input type="hidden" name="merchantSessionKey" value="<?php echo $response['merchantSessionKey'];?>">
    <input type="hidden" name="amount" value="10000">
    <input type="hidden" name="currency" value="GBP">

    <input type="hidden" name="first_name" value="Vincy">
    <input type="hidden" name="last_name" value="PhpPot">

    <input type="hidden" name="billing_address" value="88">
    <input type="hidden" name="billing_city" value="London">
    <input type="hidden" name="billing_zip" value="412">
    <input type="hidden" name="billing_country" value="GB">

    <div><input type="submit" class="btnAction"></div>
    <div id="error-message"></div>
  </form>
<script src="https://pi-test.sagepay.com/api/v1/js/sagepay.js"></script>
  <script>
    document.querySelector('[type=submit]')
            .addEventListener('click', function(e) {
                e.preventDefault();
                sagepayOwnForm({ merchantSessionKey: '<?php echo $response['merchantSessionKey']; ?>' })
                  .tokeniseCardDetails({
                      cardDetails: {
                         cardholderName: $('#card-holder-name').val(),
                         cardNumber: $("#card-number").val(),
                         expiryDate: $("#expiryMonth").val()+$("#expiryYear").val(),
                         securityCode: $("#cvv").val()
                      },
                      onTokenised : function(result) {
                        if (result.success) {
                          document.querySelector('[name="card-identifier"]').value = result.cardIdentifier;
                          document.querySelector('form').submit();
                        } else {
                        	   if(result.errors.length>0) {
                                $("#error-message").show();
                                $("#error-message").html("");
                                for(i=0;i<result.errors.length;i++) {
                                    $("#error-message").append("<div>" + result.errors[i].code+": " +result.errors[i].message + "</div>");
                                }
                            }
                        }
                      }
                  });
            }, false);
  </script>
</body>
</html>
