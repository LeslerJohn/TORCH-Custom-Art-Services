<?php

use App\Mail\WelcomeMail;
use App\Models\ArtistProfile;
use App\Models\Commission;
use App\Models\Order;
use App\Models\Refund;
use App\Models\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('send-welcome-mail', function () {
    Mail::to('leslerjohngantalao@gmail.com')->send(new WelcomeMail("Lesler John"));
    
    // Also, you can use specific mailer if your default mailer is not "mailtrap" but you want to use it for welcome mails
    // Mail::mailer('mailtrap')->to('testreceiver@gmail.com')->send(new WelcomeMail("Jon"));
})->purpose('Send welcome mail');

Artisan::command('artist:check-commissions', function () {
    $artists = ArtistProfile::with(['services.commissions' => function ($query) {
        $query->whereIn('commission.status', ['ready', 'wip']);
    }])->get();

    // Log::info($artists);

    foreach ($artists as $artist) {
        $commissionCount = 0;
        foreach ($artist->services as $service) {
            foreach ($service->commissions as $commission) {
                $commissionCount += $commission->request_quantity;
            }
        }

        if ($commissionCount >= $artist->max_commissions) {
            $artist->available = false;
            $artist->save();
        } else {
            $artist->available = true;
            $artist->save();
        }

        // Log::info($artist->username . ' - ' . $commissionCount . ' - ' . $artist->max_commissions);
    }

    $this->info('Artist commissions checked and availability updated.');
})->purpose('Check artist commissions count and update availability');

Artisan::command('request:auto-refund', function () {
    $requests = Request::where('status', 'pending')
        ->where('created_at', '<=', now()->subDays(2))
        ->get();

    foreach ($requests as $request) {
        $refund_amount = (int)($request->total_price * 100);

        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Basic ' . env('AUTH_PAY'),
        ])->post('https://api.paymongo.com/v1/refunds', [
            'data' => [
                'attributes' => [
                    'amount' => $refund_amount,
                    'payment_id' => $request->payment->transaction_id,
                    'reason' => 'unaccepted_request',
                    "send_email_receipt" => true,
                ]
            ]
        ]);

        $response_data = $response->json();

        if (isset($response_data['data'])) {
            Refund::create([
                'payment_id' => $request->payment->id,
                'request_id' => $request->id,
                'client_id' => $request->client_id,
                'artist_id' => $request->service->artist_id,
                'amount' => $refund_amount,
                'reason' => 'Artist did not accept the request within 2 days',
                'refund_method' => $request->payment->payment_method === 'GCash' ? 'GCash' : 'PayMaya',
                'status' => 'approved',
                'transaction_id' => $response_data['data']['id'],
                'admin_approved' => true,
            ]);

            $request->update(['status' => 'cancelled']);
            $request->payout->delete();
        }
    }

    $this->info('Unaccepted requests have been refunded.');
})->purpose('Automatically refund unaccepted requests after 2 days');

Artisan::command('commission:auto-complete', function () {
    $commissions = Commission::where('status', 'wip')
        ->whereHas('delivery', function ($query) {
            $query->where('status', 'delivered');
        })
        ->where('updated_at', '<=', now()->subDays(3))
        ->get();

    foreach ($commissions as $commission) {
        $commission->update(['status' => 'completed']);
    }

    $this->info('Unconfirmed commissions have been marked as completed.');
})->purpose('Automatically complete unconfirmed commissions after 3 days');

Artisan::command('order:auto-complete', function () {
    $orders = Order::where('status', 'ready')
        ->whereHas('delivery', function ($query) {
            $query->where('status', 'delivered');
        })
        ->where('updated_at', '<=', now()->subDays(3))
        ->get();

    foreach ($orders as $order) {
        $order->update(['status' => 'completed']);
    }

    $this->info('Unconfirmed orders have been marked as completed.');
})->purpose('Automatically complete unconfirmed orders after 3 days');

Schedule::command('artist:check-commissions')->everyFiveSeconds();
Schedule::command('request:auto-refund')->daily();
Schedule::command('commission:auto-complete')->daily();
Schedule::command('order:auto-complete')->daily();