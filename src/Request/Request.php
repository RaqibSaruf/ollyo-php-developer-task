<?php

declare(strict_types=1);

namespace Ollyo\Task\Request;

use Ollyo\Task\Request\Interfaces\RequestValidator;

abstract class Request implements RequestValidator
{
    protected $request = [];
    protected $errors = [];

    public function errors(): array
    {
        return $this->errors;
    }

    public function request(string $key = ''): array
    {
        if ($key === '') {
            return $this->request;
        }

        return $this->request[$key] ?? [];
    }


    abstract public function validate(): bool;
}
