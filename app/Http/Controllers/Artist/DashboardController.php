<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Order;
use App\Models\Payout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    public function index()
    {
        $artist = Auth::user()->artist;
        if (!$artist) {
            abort(404);
        }

        // Prepare data for commissions by status
        $commissionsData = Commission::select('status', DB::raw('COUNT(*) as count'))
            ->whereHas('request.service', function ($query) use ($artist) {
                $query->where('artist_id', $artist->id);
            })
            ->groupBy('status')
            ->get();

        $commissionsLabels = $commissionsData->pluck('status')->map(fn($status) => ucfirst(str_replace('_', ' ', $status)));
        $commissionsCounts = $commissionsData->pluck('count');

        // Prepare data for orders by status
        $ordersData = Order::select('status', DB::raw('COUNT(*) as count'))
            ->whereHas('items.artwork', function ($query) use ($artist) {
                $query->where('artist_id', $artist->id);
            })
            ->groupBy('status')
            ->get();

        $ordersLabels = $ordersData->pluck('status')->map(fn($status) => ucfirst(str_replace('_', ' ', $status)));
        $ordersCounts = $ordersData->pluck('count');

        $revenueData = DB::table('payouts')
            ->select(
            DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"),
            DB::raw("CAST(strftime('%Y', created_at) AS INTEGER) as year"),
            DB::raw('SUM(amount) as total')
            )
            ->where('artist_id', $artist->id)
            ->where('status', 'completed')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $reviewStatistics = DB::table('commission_review')
            ->where('artist_id', $artist->id)
            ->selectRaw('AVG(rating) as average_rating, COUNT(*) as total_reviews')
            ->first();

        $artworksSold = DB::table('artwork')
            ->where('artist_id', $artist->id)
            ->where('status', 'sold')
            ->count();

        // Prepare labels and data for charts
        $revenueLabels = $revenueData->pluck('month')->map(fn($month) => date('F', mktime(0, 0, 0, $month, 10)));
        $revenueTotals = $revenueData->pluck('total');

        $commissionStats = $this->getCommissionStats();
        $orderStats = $this->getOrderStats();

        // Fetch review data
        $reviewData = DB::table('commission_review')
            ->select(
                DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"),
                DB::raw("CAST(strftime('%Y', created_at) AS INTEGER) as year"),
                DB::raw('COUNT(*) as count')
            )
            ->where('artist_id', $artist->id)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $reviewsLabels = $reviewData->pluck('month')->map(fn($month) => date('F', mktime(0, 0, 0, $month, 10)));
        $reviewsCounts = $reviewData->pluck('count');

        // Fetch artwork sales data
        $artworksSoldData = DB::table('artwork')
            ->select(
                DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"),
                DB::raw("CAST(strftime('%Y', created_at) AS INTEGER) as year"),
                DB::raw('COUNT(*) as count')
            )
            ->where('artist_id', $artist->id)
            ->where('status', 'sold') // Check only the status column
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $artworksSoldLabels = $artworksSoldData->pluck('month')->map(fn($month) => date('F', mktime(0, 0, 0, $month, 10)));
        $artworksSoldCounts = $artworksSoldData->pluck('count');

        // Fetch pending payouts
        $pendingPayouts = Payout::where('artist_id', $artist->id)
            ->where('status', 'ready')
            ->sum('amount');

        // Fetch clients this month
        $clientsThisMonth = DB::table('order')
            ->join('order_item', 'order.id', '=', 'order_item.order_id')
            ->join('artwork', 'order_item.artwork_id', '=', 'artwork.id')
            ->where('artwork.artist_id', $artist->id)
            ->whereMonth('order.created_at', now()->month)
            ->whereYear('order.created_at', now()->year)
            ->distinct('order.client_id')
            ->count('order.client_id');

        return view('artist.dashboard', compact(
            'commissionsLabels',
            'commissionsCounts',
            'ordersLabels',
            'ordersCounts',
            'revenueLabels',
            'revenueTotals',
            'reviewStatistics',
            'artworksSold',
            'pendingPayouts',
            'reviewsLabels',
            'reviewsCounts',
            'artworksSoldLabels',
            'artworksSoldCounts',
            'clientsThisMonth'
        ));
    }

    private function getCommissionStats()
    {
        $counts = Commission::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();
    
        $labels = [];
        $data = [];
        foreach ($counts as $row) {
            $labels[] = ucfirst(str_replace('_', ' ', $row->status));
            $data[] = $row->total;
        }
        // Calculate the average range based on actual data
        $totalApplications = array_sum($data);
        $averageRange = $totalApplications > 0 ? $totalApplications / count($data) : 0;

        return [
            'labels' => $labels,
            'data' => $data,
            'averageRange' => $averageRange,
        ];
    }

    private function getOrderStats()
    {
        $counts = Order::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();
    
        $labels = [];
        $data = [];
        foreach ($counts as $row) {
            $labels[] = ucfirst(str_replace('_', ' ', $row->status));
            $data[] = $row->total;
        }
        // Calculate the average range based on actual data
        $totalApplications = array_sum($data);
        $averageRange = $totalApplications > 0 ? $totalApplications / count($data) : 0;

        return [
            'labels' => $labels,
            'data' => $data,
            'averageRange' => $averageRange,
        ];
    }

    public function exportAllStatistics()
    {
        $artist = Auth::user()->artist;
        if (!$artist) {
            abort(404);
        }

        $sections = [
            'commissions' => [
                'labels' => $this->getCommissionStats()['labels'],
                'data' => $this->getCommissionStats()['data'],
            ],
            'orders' => [
                'labels' => $this->getOrderStats()['labels'],
                'data' => $this->getOrderStats()['data'],
            ],
            'revenue' => [
                'labels' => DB::table('payouts')
                    ->select(DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"))
                    ->where('artist_id', $artist->id)
                    ->where('status', 'completed')
                    ->groupBy('month')
                    ->pluck('month')
                    ->map(fn($month) => date('F', mktime(0, 0, 0, $month, 10))),
                'data' => DB::table('payouts')
                    ->select(DB::raw('SUM(amount) as total'))
                    ->where('artist_id', $artist->id)
                    ->where('status', 'completed')
                    ->groupBy(DB::raw("CAST(strftime('%m', created_at) AS INTEGER)"))
                    ->pluck('total'),
            ],
            'reviews' => [
                'labels' => DB::table('commission_review')
                    ->select(DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"))
                    ->where('artist_id', $artist->id)
                    ->groupBy('month')
                    ->pluck('month')
                    ->map(fn($month) => date('F', mktime(0, 0, 0, $month, 10))),
                'data' => DB::table('commission_review')
                    ->select(DB::raw('COUNT(*) as count'))
                    ->where('artist_id', $artist->id)
                    ->groupBy(DB::raw("CAST(strftime('%m', created_at) AS INTEGER)"))
                    ->pluck('count'),
            ],
            'artworks_sold' => [
                'labels' => DB::table('artwork')
                    ->select(DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"))
                    ->where('artist_id', $artist->id)
                    ->where('status', 'sold')
                    ->groupBy('month')
                    ->pluck('month')
                    ->map(fn($month) => date('F', mktime(0, 0, 0, $month, 10))),
                'data' => DB::table('artwork')
                    ->select(DB::raw('COUNT(*) as count'))
                    ->where('artist_id', $artist->id)
                    ->where('status', 'sold')
                    ->groupBy(DB::raw("CAST(strftime('%m', created_at) AS INTEGER)"))
                    ->pluck('count'),
            ],
        ];

        $csvData = '';

        foreach ($sections as $sectionName => $data) {
            $csvData .= strtoupper($sectionName) . "\n";
            $csvData .= implode(',', ['Label', 'Value']) . "\n";

            foreach ($data['labels'] as $index => $label) {
                $csvData .= $label . ',' . $data['data'][$index] . "\n";
            }

            $csvData .= "\n"; // Add a blank line between sections
        }

        $filename = "artist_statistics_" . now()->format('Y-m-d') . ".csv";

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function exportCommissionList(Request $request)
    {
        $artist = Auth::user()->artist;
        if (!$artist) {
            abort(404);
        }

        $status = $request->input('status', 'all');

        // Fetch commissions based on the status filter
        $commissions = Commission::with('request.client.user')
            ->whereHas('request.service', function ($query) use ($artist) {
                $query->where('artist_id', $artist->id);
            })
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->get();

        // Check if there are commissions to export
        if ($commissions->isEmpty()) {
            return back()->with('error', 'No commissions found for the selected status.');
        }

        // Prepare CSV headers
        $headers = [
            'Status',
            'Commission Deadline',
            'Total Price',
            'Client Name',
            'Phone Number',
            'Client Shipping Address',
            'Service Details',
            'Description',
        ];

        // Initialize CSV data with headers
        $csvData = implode(',', $headers) . "\n";

        // Populate CSV rows
        foreach ($commissions as $commission) {
            $row = [
                ucfirst($commission->status),
                $commission->deadline ? \Carbon\Carbon::parse($commission->deadline)->format('Y-m-d') : 'N/A',
                number_format($commission->request->total_price, 2, '.', ','),
                $commission->request->client->user->name,
                $commission->request->client->user->phone_number ?? 'N/A',
                ($commission->request->client->user->address->house_number ?? 'N/A') . ' ' .
                ($commission->request->client->user->address->street ?? 'N/A') . ' ' .
                ($commission->request->client->user->address->barangay ?? 'N/A'),
                $commission->request->service->category->name,
                $commission->request->description,
            ];

            $csvData .= implode(',', $row) . "\n";
        }

        $filename = "commission_list_" . now()->format('Y-m-d') . ".csv";

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function exportOrderList(Request $request)
    {
        $artist = Auth::user()->artist;
        if (!$artist) {
            abort(404);
        }

        $status = $request->input('status', 'all');

        // Fetch orders based on the status filter
        $orders = Order::with('items.artwork')
            ->whereHas('items.artwork', function ($query) use ($artist) {
            $query->where('artist_id', $artist->id);
            })
            ->when($status !== 'all', function ($query) use ($status) {
            return $query->where('status', $status);
            })
            ->get();

        // Check if there are orders to export
        if ($orders->isEmpty()) {
            return back()->with('error', 'No orders found for the selected status.');
        }

        // Prepare CSV headers
        $headers = [
            'Status',
            'Order Date',
            'Order Deadline',
            'Total Price',
            'Client Name',
            'Phone Number',
            'Client Shipping Address',
            'Artwork Details'
        ];

        // Initialize CSV data with headers
        $csvData = implode(',', $headers) . "\n";

        // Populate CSV rows
        foreach ($orders as $order) {
            $artworkDetails = $order->items->map(function ($item) {
            return $item->artwork->title . ' (' . $item->artwork->price . ')';
            })->implode('; ');

            $row = [
                ucfirst($order->status),
                $order->created_at->format('Y-m-d'),
                $order->delivery ? \Carbon\Carbon::parse($order->delivery->expected_delivery)->format('Y-m-d') : 'N/A',
                number_format($order->total, 2, '.', ','),
                $order->client->user->name,
                $order->client->user->phone_number ?? 'N/A',
                ($order->client->user->address->house_number ?? 'N/A') . ' ' .
                ($order->client->user->address->street ?? 'N/A') . ' ' .
                ($order->client->user->address->barangay ?? 'N/A'),
                $artworkDetails
            ];

            $csvData .= implode(',', $row) . "\n";
        }

        $filename = "order_list_" . now()->format('Y-m-d') . ".csv";

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function availability()
    {
        $artist = Auth::user()->artist;
        $artist->update([
            'available' => request('available')
        ]);

        return back()->with('success', 'Availability updated successfully!');
    }
}
