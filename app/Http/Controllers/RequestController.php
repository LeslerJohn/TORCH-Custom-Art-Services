<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Commission;
use App\Models\Request as ModelsRequest;
use App\Models\RequestImage;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commissions = Commission::whereHas('request', function ($query) {
            $query->where('client_id', Auth::id());
        })->with('request')->latest()->get();
        $requests = ModelsRequest::where('client_id', Auth::user()->id)->latest()->get();
        return view('client.request.index', compact('requests', 'commissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Service $service)
    {
        $user = $request->user();
        $price = $request->total_price;

        $referenceIds = [];

        if ($request->hasFile('references')) {
            foreach ($request->file('references') as $file) {
                $path = $file->store('references', 'public');

                $attachment = Attachment::create([
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                ]);

                $referenceIds[] = $attachment->id;
            }
        }

        $requestData = [
            'client_id' => $user->id,
            'total_price' => $price,
            'description' => $request->description,
            'width' => $request->width,
            'height' => $request->height,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'order_type' => $request->order_type,
            'deadline' => $request->order_type === 'normal' ? now()->addDays(($service->normal_timeframe * $request->quantity) + 5) : now()->addDays(($service->rush_timeframe * $request->quantity) + 5),
            'service_id' => $service->id,
            'status' => 'pending',
            'reference_ids' => $referenceIds,
        ];

        // dd($request->all(), $service, $price, $user);
        $data = [
            'data' => [
                'attributes' => [
                    'billing' => [
                        'address' => [
                            'city' => 'Zamboanga',
                            'country' => 'PH',
                            'line1' => $user->address->house_number . ' ' . $user->address->street . ' ' . $user->address->barangay,
                            'line2' => 'address line 2',
                            'postal_code' => '7000',
                            'state' => 'PH-MNL'
                        ],
                        'email' => $user->email,
                        'name' => $user->name,
                        'phone' => $user->phone_number
                    ],
                    'line_items' => [
                        [
                            'amount' => (int)($price * 100),
                            'description' => $request->description,
                            'currency' => 'PHP',
                            'name' => $service->category->name,
                            'quantity' => (int)$request->quantity,
                            // 'images' => [
                            //     'https://images.unsplash.com/photo-1612346903007-b5ac8bb135bb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80'
                            // ],
                        ]
                    ],
                    'payment_method_types' => [
                        'gcash',
                        'paymaya',
                    ],
                    'default_payment_method_type' => 'gcash',
                    "merchant" => "Paymongo Test Account",
                    'success_url' => route('client.request.success', [
                        'requestData' => base64_encode(json_encode($requestData)), // Encode
                        'service' => $service->id
                    ]),
                    'cancel_url' => route('client.request.index'),
                    'description' => 'Request Payment',
                    'statement_descriptor' => 'Torch Payment',
                    "send_email_receipt" => true,
                    "show_description" => true,
                    "show_line_items" => true,
                ]
            ]
        ];

        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Basic ' . env('AUTH_PAY')
        ])->post('https://api.paymongo.com/v1/checkout_sessions', $data)->object();

        if (isset($response->data)) {
            Session::put(['checkout_session_id' => $response->data->id]);
            return redirect($response->data->attributes->checkout_url);
        } else {
            return redirect()->back()->withErrors(['error' => 'Payment creation failed.']);
        }
    }

    public function success($requestData, Service $service)
    {
        $decodedRequestData = json_decode(base64_decode($requestData), true); // Decode

        if (!$decodedRequestData) {
            return response()->json(['error' => 'Invalid request data'], 400);
        }

        // Retrieve checkout session
        $checkout_session_id = Session::get('checkout_session_id');
        if (!$checkout_session_id) {
            return response()->json(['error' => 'Checkout session ID not found'], 400);
        }

        $checkoutSession = Http::withOptions(['verify' => false])->withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Basic ' . env('AUTH_PAY')
        ])->get("https://api.paymongo.com/v1/checkout_sessions/{$checkout_session_id}")->object();

        if (!isset($checkoutSession->data->attributes->payments) || empty($checkoutSession->data->attributes->payments)) {
            return response()->json(['error' => 'No payments found in the checkout session'], 400);
        }

        $payment_id = $checkoutSession->data->attributes->payments[0]->id ?? null;

        if (!$payment_id) {
            return response()->json(['error' => 'Payment ID not found'], 400);
        }

        $payment = Http::withOptions(['verify' => false])->withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Basic ' . env('AUTH_PAY')
        ])->get("https://api.paymongo.com/v1/payments/{$payment_id}")->object();

        if ($payment->data->attributes->status === 'paid') {
            $modelrequest = ModelsRequest::create([
                'client_id' => Auth::user()->id,
                'total_price' => $decodedRequestData['total_price'],
                'description' => $decodedRequestData['description'],
                'width' => $decodedRequestData['width'],
                'height' => $decodedRequestData['height'],
                'quantity' => $decodedRequestData['quantity'],
                'unit' => $decodedRequestData['unit'],
                'order_type' => $decodedRequestData['order_type'],
                'deadline' => $decodedRequestData['order_type'] === 'normal'
                    ? now()->addDays(($service->normal_timeframe * $decodedRequestData['quantity']) + 5)
                    : now()->addDays(($service->rush_timeframe * $decodedRequestData['quantity']) + 5),
                'service_id' => $service->id,
                'status' => 'pending',
            ]);

            if (!empty($decodedRequestData['reference_ids'])) {
                foreach ($decodedRequestData['reference_ids'] as $attachmentId) {
                    RequestImage::create([
                        'request_id' => $modelrequest->id,
                        'attachment_id' => $attachmentId,
                    ]);
                }
            }

            return redirect()->route('client.request.index')->with('success', 'Request created successfully!');
        } else {
            return redirect()->route('client.request.index')->withErrors(['error' => 'Payment failed.']);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(ModelsRequest $request)
    {
        return view('client.request.show', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelsRequest $request)
    {
        $request->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('client.request.index')->with('success', 'Request cancelled successfully!');
    }
}
