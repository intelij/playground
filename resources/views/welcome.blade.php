<?php

 $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pi-test.sagepay.com/api/v1/merchant-session-keys",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{ "vendorName": "VENDOR_NAME" }',
            CURLOPT_HTTPHEADER => array(
                "Authorization: BASIC_AUTHORIZATION_CODE",
                "Cache-Control: no-cache",
                "Content-Type: application/json"
            )
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        $err = curl_error($curl);

        curl_close($curl);
        ?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            body {
                max-width: 550px;
                font-family: Arial;
            }

            #frmContact {
                border-top: #a2d0c8 2px solid;
                background: #e0f7f3;
                padding: 25px;
                width: 270px;
            }

            #frmContact .field-row {
                margin-bottom: 20px;
            }

            #frmContact div label {
                margin: 5px 0px 0px 5px;
                color: #49615d;
            }

            .demoInputBox {
                padding: 10px;
                border: #a5d2ca 1px solid;
                border-radius: 4px;
                background-color: #FFF;
                width: 100%;
                margin-top: 5px;
            }

            .demoSelectBox {
                padding: 10px;
                border: #a5d2ca 1px solid;
                border-radius: 4px;
                background-color: #FFF;
                margin-top: 5px;
            }

            select.demoSelectBox {
                height: 35px;
                margin-right: 10px;
            }

            .btnAction {
                background-color: #82a9a2;
                padding: 10px 40px;
                color: #FFF;
                border: #739690 1px solid;
                border-radius: 4px;
                cursor:pointer;
            }

            .btnAction:focus {
                outline: none;
            }

            .column-right {
                margin-right: 6px;
            }

            .contact-row {
                display: inline-block;
            }

            .cvv-input {
                width: 60px;
            }

            #error-message {
                margin: 20px 0px 0px;
                background: #ffd6d6;
                padding: 10px;
                border-radius: 4px;
                line-height: 25px;
                font-size: 0.9em;
                color: #907575;
                display:none;
            }

            #response-container {
                padding: 40px 20px;
                width: 270px;
                text-align:center;
            }

            .ack-message {
                font-size: 1.5em;
                margin-bottom: 20px;
            }

            #response-container.success {
                border-top: #b0dad3 2px solid;
                background: #e9fdfa;
            }

            #response-container.error {
                border-top: #c3b4b4 2px solid;
                background: #f5e3e3;
            }

            .img-response {
                margin-bottom: 30px;
            }


        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

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
                    <input type="hidden" name="merchantSessionKey" value="<?php echo isset($response['merchantSessionKey']) ? $response['merchantSessionKey'] : null;?>">
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

            </div>
        </div>

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
