<?php

namespace Academe\SagePay\Psr7\Response;

/**
 * Result of a Deferred Payment request where payment is approved or declined.
 * See Secrure3DRedirect for when the result is 3D Secure redirect.
 */

class Deferred extends Payment
{
}
