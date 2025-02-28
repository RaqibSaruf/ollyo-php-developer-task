<?php

declare(strict_types=1);

namespace Ollyo\Task\Request\Interfaces;

interface RequestValidator
{
    public function validate(): bool;
    public function errors(): array;
    public function request(string $key = ''): array;
}
