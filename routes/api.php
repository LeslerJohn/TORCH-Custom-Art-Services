<?php

use App\Events\eWalletEvents;
use App\Http\Controllers\PaymentController;
use GlennRaya\Xendivel\Invoice;
use GlennRaya\Xendivel\Xendivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

if (config('app.env') === 'local' || config('app.env') === 'testing') {
    // Invoice template - The values are hard-coded for demonstration.
    // You should supply your own data for the invoice.
    Route::get('/xendivel/invoice/template', function () {
        return view('xendivel::invoice', [
            'invoice_data' => [
                'invoice_number' => 1000023,
                'card_type' => 'VISA',
                'masked_card_number' => '400000XXXXXX0002',
                'merchant' => [
                    'name' => 'Xendivel LLC',
                    'address' => '152 Maple Avenue Greenfield, New Liberty, Arcadia USA 54331',
                    'phone' => '+63 971-444-1234',
                    'email' => 'xendivel@example.com',
                ],
                'customer' => [
                    'name' => 'Victoria Blakely',
                    'address' => 'Georgetown, 4457 Pine Circle, Rivertown, Westhaven, 98765, Silverland',
                    'email' => 'victoria@example.com',
                    'phone' => '+63 909-098-654',
                ],
                'items' => [
                    ['item' => 'iPhone 15 Pro Max', 'price' => 1099, 'quantity' => 5],
                    ['item' => 'MacBook Pro 16" M3 Max', 'price' => 2499, 'quantity' => 3],
                    ['item' => 'Apple Pro Display XDR', 'price' => 5999, 'quantity' => 2],
                    ['item' => 'Pro Stand', 'price' => 999, 'quantity' => 2],
                ],
                'tax_rate' => .12,
                'tax_id' => '123-456-789',
                'footer_note' => 'Thank you for your recent purchase with us! We are thrilled to have the opportunity to serve you and hope that your new purchase brings you great satisfaction.',
            ],
        ]);
    });

    Route::get('/xendivel/checkout/blade', function () {
        return view('xendivel::checkout');
    });

    Route::get('/payment', function () {
        // card charge id example: 659518586a863f003659b718
        $response = Xendivel::getPayment('card-charge-id', 'card')
            ->getResponse();
    
        return $response;
    });

    Route::post('/pay-via-ewallet', function (Request $request) {
        $response = Xendivel::payWithEwallet($request)
            ->getResponse();

        return $response;
    });

    Route::get('/get-ewallet-charge', function (Request $request) {
        $response = Xendivel::getPayment('ewc_65cbfb33-a1ea-4c32-a6f3-6f8202de9d6e', 'ewallet')
            ->getResponse();
    
        return $response;
    });

    // Will generate an invoice and store it in storage. But will not download it right away.
    Route::get('/xendivel/invoice/generate', function () {
        return Invoice::make([
            'invoice_number' => 1000023,
            'card_type' => 'VISA',
            'masked_card_number' => '400000XXXXXX0002',
            'merchant' => [
                'name' => 'Xendivel LLC',
                'address' => '152 Maple Avenue Greenfield, New Liberty, Arcadia USA 54331',
                'phone' => '+63 971-444-1234',
                'email' => 'xendivel@example.com',
            ],
            'customer' => [
                'name' => 'Victoria Marini',
                'address' => 'Alex Johnson, 4457 Pine Circle, Rivertown, Westhaven, 98765, Silverland',
                'email' => 'victoria@example.com',
                'phone' => '+63 909-098-654',
            ],
            'items' => [
                ['item' => 'iPhone 15 Pro Max', 'price' => 1099, 'quantity' => 5],
                ['item' => 'MacBook Pro 16" M3 Max', 'price' => 2499, 'quantity' => 3],
                ['item' => 'Apple Pro Display XDR', 'price' => 5999, 'quantity' => 2],
                ['item' => 'Pro Stand', 'price' => 999, 'quantity' => 2],
            ],
            'tax_rate' => .12,
            'tax_id' => '123-456-789',
            'footer_note' => 'Thank you for your recent purchase with us! We are thrilled to have the opportunity to serve you and hope that your new purchase brings you great satisfaction.',
        ])
            ->save();
    });

    // Download example invoice.
    Route::get('/xendivel/invoice/download', function () {
        $invoice_data = [
            'invoice_number' => 1000023,
            'card_type' => 'VISA',
            'masked_card_number' => '400000XXXXXX0002',
            'merchant' => [
                'name' => 'Xendivel LLC',
                'address' => '152 Maple Avenue Greenfield, New Liberty, Arcadia USA 54331',
                'phone' => '+63 971-444-1234',
                'email' => 'xendivel@example.com',
            ],
            'customer' => [
                'name' => 'Glenn Raya',
                'address' => 'Alex Johnson, 4457 Pine Circle, Rivertown, Westhaven, 98765, Silverland',
                'email' => 'victoria@example.com',
                'phone' => '+63 909-098-654',
            ],
            'items' => [
                ['item' => 'iPhone 15 Pro Max', 'price' => 1099, 'quantity' => 5],
                ['item' => 'MacBook Pro 16" M3 Max', 'price' => 2499, 'quantity' => 3],
                ['item' => 'Apple Pro Display XDR', 'price' => 5999, 'quantity' => 2],
                ['item' => 'Pro Stand', 'price' => 999, 'quantity' => 2],
            ],
            'tax_rate' => .12,
            'tax_id' => '123-456-789',
            'footer_note' => 'Thank you for your recent purchase with us! We are thrilled to have the opportunity to serve you and hope that your new purchase brings you great satisfaction.',
        ];

        // return Invoice::download($invoice_data);
        return Invoice::make($invoice_data)
            ->download();
    });

    // Example card charge, then send invoice to email as an attachment.
    Route::post('/pay-with-card', function (Request $request) {
        $payment = Xendivel::payWithCard($request)
            ->getResponse();

        return $payment;
    });

    // Example card charge, then send invoice to email as an attachment.
    Route::post('/pay-with-card-email-invoice', function (Request $request) {
        $invoice_data = [
            'invoice_number' => 1000023,
            'card_type' => 'VISA',
            'masked_card_number' => '400000XXXXXX0002',
            'merchant' => [
                'name' => 'Stark Industries',
                'address' => '152 Maple Avenue Greenfield, New Liberty, Arcadia USA 54331',
                'phone' => '+63 971-444-1234',
                'email' => 'xendivel@example.com',
            ],
            'customer' => [
                'name' => 'Mr. Glenn Raya',
                'address' => 'Alex Johnson, 4457 Pine Circle, Rivertown, Westhaven, 98765, Silverland',
                'email' => 'victoria@example.com',
                'phone' => '+63 909-098-654',
            ],
            'items' => [
                ['item' => 'MacBook Pro 16" M3 Max', 'price' => $request->amount, 'quantity' => 1],
            ],
            'tax_rate' => .12,
            'tax_id' => '123-456-789',
            'footer_note' => 'Thank you for your recent purchase with us! We are thrilled to have the opportunity to serve you and hope that your new purchase brings you great satisfaction.',
        ];

        $payment = Xendivel::payWithCard($request)
            ->emailInvoiceTo('glenn@example.com', $invoice_data)
            ->send()
            ->getResponse();

        return $payment;
    });

    Route::post('/pay-via-ewallet', function (Request $request) {
        $payment = Xendivel::payWithEWallet($request)
            ->getResponse();

        return $payment;
    });
}

// Listen to webhook events from Xendit. This will fire up an event listener
// where you can perform whatever task you need with the returned data.
Route::post(config('xendivel.webhook_url'), function (Request $request) {

    event(new eWalletEvents($request->toArray()));

})->middleware('xendit-webhook-verification');

Route::get('/paymongo/payment', [PaymentController::class, 'pay'])->name('paymongo.payment');
Route::get('/disbursement', [PaymentController::class, 'disbursementForm'])->name('disbursement');
Route::post('/disburse', [PaymentController::class, 'disburseToLandlords'])->name('payment.disburse');