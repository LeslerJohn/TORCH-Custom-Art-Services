<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $artist = Auth::user()->artist;
        if (!$artist) {
            abort(404);
        }

        $totalRevenue = Order::whereHas('items.artwork', function ($query) use ($artist) {
            $query->where('artist_id', $artist->id);
        })->where('status', 'completed')->sum('total');

        $ongoingCommissionsCount = Commission::where('artist_id', $artist->id)
            ->whereNotIn('status', ['done', 'completed'])
            ->count();

        $ongoingOrdersCount = Order::whereHas('items.artwork', function ($query) use ($artist) {
            $query->where('artist_id', $artist->id);
        })->whereNotIn('status', ['completed', 'cancelled'])->count();

        $toDeliverCount = Order::whereHas('items.artwork', function ($query) use ($artist) {
            $query->where('artist_id', $artist->id);
        })->whereHas('delivery', function ($query) {
            $query->where('status', 'in-transit');
        })->count();

        $averageReview = DB::table('order_review') 
            ->join('order', 'order_review.order_id', '=', 'order.id') // Join with the order table to get the artwork_id
            ->join('order_item', 'order.id', '=', 'order_item.order_id')
            ->join('artwork', 'order_item.artwork_id', '=', 'artwork.id')
            ->where('artwork.artist_id', $artist->id)
            ->avg('rating');

        $totalBudget = $this->calculateTotalBudget($artist); 

        $ongoingCommissions = Commission::where('artist_id', $artist->id)
            ->whereNotIn('status', ['done', 'completed'])
            ->with('request.service.category') 
            ->get();

        $ongoingOrders = Order::whereHas('items.artwork', function ($query) use ($artist) {
            $query->where('artist_id', $artist->id);
        })->whereNotIn('status', ['completed', 'cancelled'])
            ->get();

        $recentReviews = DB::table('order_review')
            ->join('order', 'order_review.order_id', '=', 'order.id')
            ->join('order_item', 'order.id', '=', 'order_item.order_id')
            ->join('artwork', 'order_item.artwork_id', '=', 'artwork.id')
            ->where('artwork.artist_id', $artist->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $completedCommissionsCount = Commission::where('artist_id', $artist->id)
            ->where('status', 'completed')
            ->count();

        return view('artist.dashboard', compact(
            'artist',
            'totalRevenue',
            'ongoingCommissionsCount',
            'ongoingOrdersCount',
            'toDeliverCount',
            'averageReview',
            'totalBudget',
            'ongoingCommissions',
            'ongoingOrders',
            'recentReviews',
            'completedCommissionsCount'
        ));
    }

    private function calculateTotalBudget($artist)
    {
        // Example:  Sum of prices of artworks where status is 'sale' or 'draft'
        return $artist->artworks()->whereIn('status', ['sale', 'draft'])->sum('price');

        // Or, if budget comes from commissions:
        // return $artist->commissions()->sum('total_price'); // If your commissions table has a total price
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
