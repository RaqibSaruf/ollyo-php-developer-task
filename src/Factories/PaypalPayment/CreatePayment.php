<?php

declare(strict_types=1);

namespace Ollyo\Task\Factories\PaypalPayment;

use PaypalServerSdkLib\Models\Builders\AmountWithBreakdownBuilder;
use PaypalServerSdkLib\Models\Builders\OrderRequestBuilder;
use PaypalServerSdkLib\Models\Builders\PurchaseUnitRequestBuilder;
use PaypalServerSdkLib\Models\CheckoutPaymentIntent;

class CreatePayment
{
    /**
     * This function can be used to create payout. 
     */
    public function CreateOrder($total)
    {
        $client = PaypalClient::client();
        $ordersController = $client->getOrdersController();
        $collect = [
            'body' => OrderRequestBuilder::init(
                CheckoutPaymentIntent::CAPTURE,
                [
                    PurchaseUnitRequestBuilder::init(
                        AmountWithBreakdownBuilder::init(
                            'USD',
                            (string)$total
                        )->build()
                    )->build()
                ]
            )->build(),
            'prefer' => 'return=minimal'
        ];

        $apiResponse = $ordersController->ordersCreate($collect);
        if ($apiResponse->isSuccess()) {
            $result = json_decode($apiResponse->getBody(), true);
            header("Location: " . $result['links'][1]['href']);
            exit;
        }

        throw new \Exception("Can't process", 500);
    }
}
