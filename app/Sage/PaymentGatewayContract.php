<?php
/**
 * Created by PhpStorm.
 * User: khululekanimkhonza
 * Date: 29/10/2019
 * Time: 05:28
 */

namespace App\Sage;

interface PaymentGatewayContract
{
    /**
     * @param int $discount
     */
    public function setDiscount(int $discount): void;

    public function charge($amount);
}
