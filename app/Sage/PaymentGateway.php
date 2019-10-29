<?php
/**
 * Created by PhpStorm.
 * User: khululekanimkhonza
 * Date: 29/10/2019
 * Time: 04:49
 */

namespace App\Sage;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class PaymentGateway implements PaymentGatewayContract
{
    private $currency;
    private $discount;

    public function __construct($currency)
    {
        $this->currency = $currency;
        $this->discount = 0;
    }

    /**
     * @param int $discount
     */
    public function setDiscount(int $discount): void
    {
        $this->discount = $discount;
    }

    public function charge($amount) {

        return [
            'amount' => $amount - $this->discount,
            'confirmation_number' => Str::random(),
            'currency' => $this->currency,
            'discount' => $this->discount,
            'http' => $this->http(),
        ];
    }

    public function getSessionKey() {

        $client = new \GuzzleHttp\Client();

        $response = $client->post('https://connect.stripe.com/oauth/deauthorize', [
            'auth' => ['XXXXX', ''],
            'form_params' => [
                'client_id' => 'ca_8e8Y5aZOmUEaM47nBRYvL6NirsnkEKPD',
                'stripe_user_id' => 'acct_Ng24IGpK2whxwj',
            ]]);

        return $response['merchantSessionKey'];
    }

    public function http() {

        $client = new Client();

        $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');

        echo $response->getStatusCode(); # 200
        echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
        echo $response->getBody(); # '{"id": 1420053, "name": "guzzle", ...}'

        # Send an asynchronous request.
        $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
        $promise = $client->sendAsync($request)->then(function ($response) {
            echo 'I completed! ' . $response->getBody();
        });

        $promise->wait();
    }

    public function getSagePayMerchantSessionKey() {

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

    }

    public function makePayment() {

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

    }

}
