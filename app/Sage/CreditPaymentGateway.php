<?php
/**
 * Created by PhpStorm.
 * User: khululekanimkhonza
 * Date: 29/10/2019
 * Time: 04:49
 */

namespace App\Sage;


use Illuminate\Support\Str;

class CreditPaymentGateway implements PaymentGatewayContract
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

        $charge = $amount * 0.03;

        return [
            'amount' => ($amount - $this->discount) + $charge,
            'confirmation_number' => Str::random(),
            'currency' => $this->currency,
            'discount' => $this->discount,
            'charge' => $charge
        ];
    }

}
