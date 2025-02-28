<?php

declare(strict_types=1);

namespace Ollyo\Task\Controllers;

use Ollyo\Task\Request\Interfaces\RequestValidator;
use Ollyo\Task\Services\Interfaces\Payable;
use Ollyo\Task\Services\Interfaces\PriceCalculator;

class PaymentController extends Controller
{

    public function success(array $request)
    {
        return view('success', $request);
    }

    public function failure(array $request)
    {
        return view('failure', $request);
    }
}
