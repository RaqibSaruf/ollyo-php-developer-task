<?php

declare(strict_types=1);

namespace Ollyo\Task\Request;


class CheckoutRequest extends Request
{
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function validate(): bool
    {
        $request = $this->request();

        if (empty($request)) {
            $this->errors = [
                'products' => 'products is required'
            ];
            return false;
        }

        foreach ($request['products'] as $key => $product) {
            if (!filter_var($product['price'], FILTER_VALIDATE_INT) && !filter_var($product['price'], FILTER_VALIDATE_FLOAT) && $product['price'] > 0) {
                $this->errors['products'][$key]['price'] = [
                    "message" => "price must be a valid positive number",
                    "value" => $product['price']
                ];
            }

            if (!filter_var($product['qty'], FILTER_VALIDATE_INT) && $product['qty'] > 0) {
                $this->errors['products'][$key]['qty'] = [
                    "message" => "price must be a valid positive number",
                    "value" => $product['qty']
                ];
            }
        }

        $shippingData = $request['shipping'];
        if (empty($shippingData['cost'])) {
            $this->errors['shipping']['cost'] = [
                "message" => 'cost is required',
                "value" => $shippingData['cost']
            ];
        }

        if (!filter_var($shippingData['cost'], FILTER_VALIDATE_INT) && !filter_var($shippingData['cost'], FILTER_VALIDATE_FLOAT) && $shippingData['cost'] >= 0) {
            $this->errors['shipping']['cost'] = [
                "message" => 'cost must be a valid positive number',
                "value" => $shippingData['cost']
            ];
        }

        if (empty(trim($shippingData['name']))) {
            $this->errors['shipping']['name'] = [
                "message" => 'name is required',
                "value" => $shippingData['name'],
            ];
        }

        if (empty(trim($shippingData['email'])) || !filter_var(trim($shippingData['email']), FILTER_VALIDATE_EMAIL)) {
            $this->errors['shipping']['email'] = [
                "message" => 'please provide valid email address',
                "value" => $shippingData['email'],
            ];
        }

        if (empty(trim($shippingData['address']))) {
            $this->errors['shipping']['address'] = [
                "message" => 'address is required',
                "value" => $shippingData['address'],
            ];
        }

        if (empty(trim($shippingData['city']))) {
            $this->errors['shipping']['city'] = [
                "message" => 'city is required',
                "value" => $shippingData['city'],
            ];
        }

        if (empty(trim($shippingData['post_code']))) {
            $this->errors['shipping']['post_code'] = [
                "message" => 'post code is required',
                "value" => $shippingData['post_code'],
            ];
        }



        if (!empty($this->errors())) {
            return false;
        }

        return true;
    }
}
