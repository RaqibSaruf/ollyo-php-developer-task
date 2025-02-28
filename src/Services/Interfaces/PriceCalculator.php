<?php

declare(strict_types=1);

namespace Ollyo\Task\Services\Interfaces;

interface PriceCalculator
{
    public function calculatePrice(array $products);
}
