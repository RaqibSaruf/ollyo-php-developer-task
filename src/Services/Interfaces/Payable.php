<?php

declare(strict_types=1);

namespace Ollyo\Task\Services\Interfaces;

interface Payable
{
    public function pay($total);
}
