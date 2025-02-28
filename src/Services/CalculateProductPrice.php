<?php

declare(strict_types=1);

namespace Ollyo\Task\Services;

use Ollyo\Task\Services\Interfaces\PriceCalculator;

class CalculateProductPrice implements PriceCalculator
{
    public function calculatePrice(array $products)
    {
        $subtotal = 0;

        foreach ($products as $product) {
            $subtotal += $product['price'] * $product['qty'];
        }

        return $subtotal;
    }
}
