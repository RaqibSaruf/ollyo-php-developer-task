<?php

use Ollyo\Task\Controllers\CheckoutController;
use Ollyo\Task\Controllers\PaymentController;
use Ollyo\Task\Request\CheckoutRequest;
use Ollyo\Task\Routes;
use Ollyo\Task\Services\CalculateProductPrice;
use Ollyo\Task\Services\PaymentService;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helper.php';

define('BASE_PATH', dirname(__FILE__));
define('BASE_URL', baseUrl());
define('PAYPAL_URL', "https://api-m.sandbox.paypal.com");
define('PAYPAL_CLIENT_ID', "AeynyZpZjen7PwYPvHz3tTVNEOdSRs-m0FboNorM3n3CDOZGBXDBJVfQIljWB7Qt6Ldtor2EmqPpSsiq");
define('PAYPAL_CLIENT_SECRET', "EC0Hb-5rMD4W1cAs5zPefzx7eZGAzqx5qhrDYz6GIgWiNWa48bO8JCCgiK5rdiS9wK0jZb-eBmY_ve_N");

set_exception_handler(function (Throwable $th) {
    http_response_code($th->getCode() ?? 500);
    echo $th->getMessage();
    exit;
});

$products = [
    [
        'name' => 'Minimalist Leather Backpack',
        'image' => BASE_URL . '/resources/images/backpack.webp',
        'qty' => 1,
        'price' => 120,
    ],
    [
        'name' => 'Wireless Noise-Canceling Headphones',
        'image' => BASE_URL . '/resources/images/headphone.jpg',
        'qty' => 1,
        'price' => 250,
    ],
    [
        'name' => 'Smart Fitness Watch',
        'image' => BASE_URL . '/resources/images/watch.webp',
        'qty' => 1,
        'price' => 199,
    ],
    [
        'name' => 'Portable Bluetooth Speaker',
        'image' => BASE_URL . '/resources/images/speaker.webp',
        'qty' => 1,
        'price' => 89,
    ],
];
$shippingCost = 10;

$data = [
    'products' => $products,
    'shipping_cost' => $shippingCost,
    'address' => [
        'name' => 'Sherlock Holmes',
        'email' => 'sherlock@example.com',
        'address' => '221B Baker Street, London, England',
        'city' => 'London',
        'post_code' => 'NW16XE',
    ]
];

Routes::get('/', function () {
    return view('app', ["test" => "test"]);
});

Routes::get('/checkout', function () use ($data) {
    return view('checkout', $data);
});

Routes::post('/checkout', function ($request) use ($data) {
    // @todo: Implement PayPal payment gateway integration here
    // 1. Initialize PayPal API client with credentials
    // 2. Create payment with order details from $data
    // 3. Execute payment and handle response
    // 4. If payment successful, save order and redirect to thank you page
    // 5. If payment fails, redirect to error payment page with message

    // Consider creating a dedicated controller class to handle payment processing
    // This helps separate payment logic from routing and keeps code organized
    $controller = new CheckoutController(new PaymentService(), new CalculateProductPrice());
    return $controller->checkout(new CheckoutRequest($request), $data);
});

Routes::get('/payment-succesfull', function ($request) {
    $paymentController = new PaymentController();
    return $paymentController->success($request);
});

Routes::get('/payment-failed', function ($request) {
    $paymentController = new PaymentController();
    return $paymentController->failure($request);
});

// Register thank you & payment failed routes with corresponding views here.

$route = Routes::getInstance();
$route->dispatch();
