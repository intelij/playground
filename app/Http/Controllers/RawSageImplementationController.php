<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RawSageImplementationController extends Controller
{
    public function index() {

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
//        return view('welcome');
    }

    public function processPayment() {


    }

}
