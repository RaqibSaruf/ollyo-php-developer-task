<?php

declare(strict_types=1);

namespace Ollyo\Task\Services;

use Ollyo\Task\Factories\PaypalPayment;
use Ollyo\Task\Services\Interfaces\Payable;

class PaymentService implements Payable
{
    public function pay($total)
    {
        $class = PaypalPayment::create('CreatePayment');
        $class->CreateOrder($total);
    }
}
