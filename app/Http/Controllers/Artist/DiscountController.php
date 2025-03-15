<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Auth::user()->artist->discounts;
        $artworks = Auth::user()->artist->artworks()->whereDoesntHave('discount')->get();
        return view('artist.discount.index', compact('discounts', 'artworks'));
    }

    public function create(){
        return view('artist.discount.index');
    }

    public function store(Request $request){

        $artwork = Artwork::findOrFail($request->artwork_id);
        
        $request->validate([
            'artwork_id' => 'required|exists:artwork,id',
            'value_type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0|max:' . ($request->value_type === 'percentage' ? 75 : ($artwork->price * 0.75)),
        ]);

        Discount::create([
            'artwork_id' => $request->artwork_id,
            'value_type' => $request->value_type,
            'value' => $request->value,
        ]);
        return redirect()->route('artist.discount.index')->with('success', 'Discount created successfully');
    }

    public function status_update(Discount $discount)
    {
        $discount->update([
            'status' => $discount->status === 'active' ? 'inactive' : 'active',
        ]);
        return redirect()->route('artist.discount.index')->with('success', 'Discount updated successfully');
    }

    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'value_type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0' . ($request->value_type === 'percentage' ? '|max:75' : '|max:' . ($discount->artwork->price * 0.75)),
        ]);

        $discount->update([
            'value_type' => $request->value_type,
            'value' => $request->value,
        ]);
        return redirect()->route('artist.discount.index')->with('success', 'Discount updated successfully');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('artist.discount.index')->with('success', 'Discount deleted successfully');
    }
}
