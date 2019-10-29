<?php

namespace App\Http\Controllers;

use App\Order\OrderDetails;
use App\Sage\PaymentGateway;
use App\Sage\PaymentGatewayContract;
use Illuminate\Http\Request;

class PayOrderController extends Controller
{
    public function store(OrderDetails $orderDetails, PaymentGatewayContract $paymentGateway) {

        $order = $orderDetails->getOrder();

        dump($order, $paymentGateway->charge(2400));

    }
}
