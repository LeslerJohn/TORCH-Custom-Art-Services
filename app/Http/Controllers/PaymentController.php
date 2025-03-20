<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    // public function pay()
    // {
    //     $name = 'Ruderick';

    //     $data = [
    //         'data' => [
    //             'attributes' => [
    //                 'line_items' => [
    //                     [
    //                         'amount' => 10000,
    //                         'description' => 'Test Payment',
    //                         'currency' => 'PHP',
    //                         'name' => $name,
    //                         'quantity' => 1,
    //                     ]
    //                 ],
    //                 'payment_method_types' => [
    //                     'gcash',
    //                     'paymaya',
    //                 ],
    //                 'success_url' => 'http://localhost:8000/success',
    //                 'cancel_url' => 'http://localhost:8000/',
    //                 'description' => 'Test Payment',
    //             ]
    //         ]
    //     ];

    //     $response = Http::withOptions(['verify' => false])->withHeaders([
    //         'Content-Type' => 'application/json',
    //         'accept' => 'application/json',
    //         'Authorization' => 'Basic ' . env('AUTH_PAY')
    //         ])->post('https://api.paymongo.com/v1/checkout_sessions', $data)->object();


    //     Session::put(['payment_id' => $response->data->id]);

    //     return redirect($response->data->attributes->checkout_url);

    // }
    public function pay()
    {
        // $name = 'Ruderick';
        // $amount = 1000000;
        // $description = 'Test Payment';
        // $quantity = 1;

        // $data = [
        //     'data' => [
        //         'attributes' => [
        //             'billing' => [
        //                 'address' => [
        //                     'city' => 'Taguig',
        //                     'country' => 'PH',
        //                     'line1' => 'address line 1',
        //                     'line2' => 'address line 2',
        //                     'postal_code' => '1234',
        //                     'state' => 'PH-MNL'
        //                 ],
        //                 'email' => 'leslerjohngantalao@gmail.com',
        //                 'name' => 'John doe',
        //                 'phone' => '09123456789'
        //             ],
        //             'line_items' => [
        //                 [
        //                     'amount' => $amount,
        //                     'description' => $description,
        //                     'currency' => 'PHP',
        //                     'name' => $name,
        //                     'quantity' => $quantity,
        //                     'images' => [
        //                         'https://images.unsplash.com/photo-1612346903007-b5ac8bb135bb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80'
        //                     ],
        //                 ]
        //             ],
        //             'payment_method_types' => [
        //                 'gcash',
        //                 'paymaya',
        //             ],
        //             'default_payment_method_type' => 'gcash',
        //             "merchant" => "Paymongo Test Account",
        //             'success_url' => 'http://localhost:8000/success',
        //             'cancel_url' => 'http://localhost:8000/',
        //             'description' => 'Order Payment',
        //             'statement_descriptor' => 'Torch Payment',
        //             "send_email_receipt" => true,
        //             "show_description" => true,
        //             "show_line_items" => true,
        //         ]
        //     ]
        // ];

        // $response = Http::withOptions(['verify' => false])->withHeaders([
        //     'Content-Type' => 'application/json',
        //     'accept' => 'application/json',
        //     'Authorization' => 'Basic ' . env('AUTH_PAY')
        //     ])->post('https://api.paymongo.com/v1/checkout_sessions', $data)->object();

        // if (isset($response->data)) {
        //     Session::put(['payment_id' => $response->data->id]);
        //     return redirect($response->data->attributes->checkout_url);
        // } else {
        //     return redirect()->back()->withErrors(['error' => 'Payment creation failed.']);
        // }

        // return redirect($response->data->attributes->checkout_url);

        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . env('AUTH_PAY'),
        ])->post('https://api.paymongo.com/v1/payouts', [
            'data' => [
                'attributes' => [
                    'amount' => 10100, // Convert PHP to centavos
                    'currency' => 'PHP',
                    'payout_type' => 'paymaya', // 'gcash' or 'bank' also available
                    'destination' => [
                        'type' => 'gcash', // 'gcash' | 'bank_account'
                        'id' => 'org_hwqYTbRCnV9W5MwyS6BhaLuh' // Artist's PayMongo account ID
                    ],
                    'remarks' => "Payout to artist me.",
                ]
            ]
        ]);

        dd($response->json());
    }

    public function disbursementForm()
    {
        return view('payment.disbursement');
    }

    public function disburseToLandlords(Request $request)
    {
        // Validate the request data
        $request->validate([
            'landlords' => 'required|array',
            'landlords.*.name' => 'required|string',
            'landlords.*.amount' => 'required|numeric',
            'landlords.*.account_number' => 'required|string',
            'landlords.*.bank_code' => 'required|string',
        ]);

        $paymentResults = [];
        $landlords = $request->input('landlords');

        foreach ($landlords as $landlord) {
            // Step 1: Create a payment intent for each landlord
            $paymentIntentData = [
                'data' => [
                    'attributes' => [
                        'amount' => $landlord['amount'] * 100, // Convert to smallest currency unit
                        'payment_method_allowed' => ['gcash'],
                        'payment_method_options' => [
                            'card' => ['request_three_d_secure' => 'any']
                        ],
                        'currency' => 'PHP',
                        'description' => 'Disbursement to ' . $landlord['name'],
                        'statement_descriptor' => 'ResiSync Payment'
                    ]
                ]
            ];

            $paymentIntentResponse = Http::withOptions(['verify' => false])->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . env('AUTH_PAY')
            ])->post('https://api.paymongo.com/v1/payment_intents', $paymentIntentData)->object();

            if (!isset($paymentIntentResponse->data)) {
                $paymentResults[] = [
                    'landlord' => $landlord['name'],
                    'status' => 'failed',
                    'message' => 'Failed to create payment intent',
                    'error' => $paymentIntentResponse->errors ?? null
                ];
                continue;
            }

            $paymentIntentId = $paymentIntentResponse->data->id;

            // Step 2: Create a payment method (simulating bank transfer)
            $paymentMethodData = [
                'data' => [
                    'attributes' => [
                        'type' => 'gcash', // You can change this based on requirements
                        'details' => [
                            'account_number' => $landlord['account_number'],
                            'bank_code' => $landlord['bank_code']
                        ],
                        'billing' => [
                            'name' => $landlord['name'],
                            'email' => $landlord['email'] ?? 'landlord@example.com',
                            'phone' => $landlord['phone'] ?? '09123456789'
                        ]
                    ]
                ]
            ];

            $paymentMethodResponse = Http::withOptions(['verify' => false])->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . env('AUTH_PAY')
            ])->post('https://api.paymongo.com/v1/payment_methods', $paymentMethodData)->object();

            if (!isset($paymentMethodResponse->data)) {
                $paymentResults[] = [
                    'landlord' => $landlord['name'],
                    'status' => 'failed',
                    'message' => 'Failed to create payment method',
                    'payment_intent_id' => $paymentIntentId,
                    'error' => $paymentMethodResponse->errors ?? null
                ];
                continue;
            }

            $paymentMethodId = $paymentMethodResponse->data->id;

            // Step 3: Attach the payment method to the payment intent
            $attachData = [
                'data' => [
                    'attributes' => [
                        'payment_method' => $paymentMethodId,
                        'return_url' => route('payment.success')
                    ]
                ]
            ];

            $attachResponse = Http::withOptions(['verify' => false])->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . env('AUTH_PAY')
            ])->post("https://api.paymongo.com/v1/payment_intents/{$paymentIntentId}/attach", $attachData)->object();

            if (!isset($attachResponse->data)) {
                $paymentResults[] = [
                    'landlord' => $landlord['name'],
                    'status' => 'failed',
                    'message' => 'Failed to attach payment method',
                    'payment_intent_id' => $paymentIntentId,
                    'payment_method_id' => $paymentMethodId,
                    'error' => $attachResponse->errors ?? null
                ];
                continue;
            }

            // Record successful transaction
            $paymentResults[] = [
                'landlord' => $landlord['name'],
                'status' => 'success',
                'payment_intent_id' => $paymentIntentId,
                'payment_method_id' => $paymentMethodId,
                'transaction_status' => $attachResponse->data->attributes->status,
                'amount' => $landlord['amount'],
                'metadata' => $attachResponse->data->attributes->metadata ?? null
            ];
        }
    

        // Store the payment results in session for reference
        Session::put('disbursement_results', $paymentResults);

        return response()->json([
            'success' => true,
            'message' => 'Disbursement process completed',
            'results' => $paymentResults
        ]);
    }
}
