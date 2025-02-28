<?php

declare(strict_types=1);

namespace Ollyo\Task\Factories;

class PaypalPayment
{
    public static function create($className = '')
    {
        $class = "\Ollyo\Task\Factories\PaypalPayment\\" . $className;

        if (!class_exists($class)) {
            throw new \Exception("Can't create className object");
        }

        return new $class();
    }
}
