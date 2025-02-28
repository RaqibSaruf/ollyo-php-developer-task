<?php

declare(strict_types=1);

namespace Ollyo\Task\Controllers;

use Ollyo\Task\Request\Interfaces\RequestValidator;
use Ollyo\Task\Services\Interfaces\Payable;
use Ollyo\Task\Services\Interfaces\PriceCalculator;

class CheckoutController extends Controller
{
    public function __construct(private Payable $paymentService, private PriceCalculator $calculator) {}

    public function checkout(RequestValidator $validator, array $prevData)
    {
        $valid = $validator->validate();

        if (!$valid) {
            return view('checkout', [...$prevData, "errors" => $validator->errors()]);
        }


        $prevSubtotal = $this->calculator->calculatePrice($prevData['products']);
        $prevTotal = $prevSubtotal + ($prevData['shipping_cost'] ?? 0);
        $subtotal = $this->calculator->calculatePrice($validator->request('products'));
        $total = $subtotal + ($validator->request('shipping')['cost'] ?? 0);

        if ($prevTotal !== $total) {
            throw new \Exception("Something went wrong.", 500);
        }

        $this->paymentService->pay($total);


        return view('app');
    }
}
