<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\CommissionReview;
use App\Models\Order;
use App\Models\OrderReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $order_reviews = OrderReview::whereHas('order.items.artwork', function ($query) {
            $query->whereHas('artist', function ($q) {
                $q->where('id', Auth::user()->id);
            });
        })
            ->whereNotNull('review')
            ->with([
                'order.client',
                'order.items.artwork.images.attachment',
                'order.items.artwork.category',
                'order.items.artwork.artist'
            ])
            ->latest()
            ->get();

        $commission_reviews = CommissionReview::whereHas('commission.request', function ($query) {
            $query->whereHas('service', function ($q) {
                $q->whereHas('artist', function ($subQ) {
                    $subQ->where('id', Auth::user()->id);
                });
            });
        })
            ->whereNotNull('review')
            ->with([
                'commission.request.client',
                'commission.request.images.attachment',
                'commission.request.service.category',
                'commission.request.service.artist'
            ])
            ->latest()
            ->get();

        return view('artist.review.index', compact('order_reviews', 'commission_reviews'));
    }
}
