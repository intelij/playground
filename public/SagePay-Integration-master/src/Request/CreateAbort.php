<?php

namespace Academe\SagePay\Psr7\Request;

/**
 * The "abort" instruction request.
 * Abort a deferred transaction so the customer is not charged.
 * Use, for example, if unable to fulfil an order.
 */

class CreateAbort extends AbstractInstruction
{
    protected $instructionType = 'abort';
}
