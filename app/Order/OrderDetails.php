<?php
/**
 * Created by PhpStorm.
 * User: khululekanimkhonza
 * Date: 29/10/2019
 * Time: 05:14
 */

namespace App\Order;


use App\Sage\PaymentGateway;
use App\Sage\PaymentGatewayContract;

class OrderDetails
{

    private $paymentGateway;

    public function __construct(PaymentGatewayContract $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function getOrder()
    {
        $this->paymentGateway->setDiscount(12);

        return [
            'name' => 'Khululekani Mkhonza',
            'address' => '126 Wolds Drive, Keyworth, NG12 5DA',
        ];
    }
}
