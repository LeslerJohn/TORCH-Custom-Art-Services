<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ArtistProfile;

class ArtistApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get data from function and pass it on graph
        $applicationStats = $this->getApplicationStats();
        $artistStats = $this->getUserStats('artist');
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        }

        $users = $query->where('role', 'artist')->paginate(10);

        return view('admin.application.index', compact('users'), [
            'chartLabels' => $applicationStats['labels'],
            'chartData' => $applicationStats['data'],
            'averageRange' => $applicationStats['averageRange'],
            'artistLabels' => $artistStats['labels'],
            'artistData' => $artistStats['data'],
            'artistsCountThisMonth' => $artistStats['countThisMonth'],
            'artistTrendIndicator' => $artistStats['trendIndicator'],
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.application.show', compact('user'));
    }

    public function approve(string $id)
    {
        $user = User::findOrFail($id);
        $user->artist->update(['status' => 'semi-verified']);
        return redirect()->route('admin.application.index');
    }

    public function reject(string $id)
    {
        $user = User::findOrFail($id);
        $user->artist->update(['status' => 'unverified']);
        return redirect()->route('admin.application.index');
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
    public function destroy(string $id)
    {
        //
    }

    private function getApplicationStats()
    {
        $counts = ArtistProfile::select('status', DB::raw('COUNT(*) as total'))
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

    private function getUserStats($role)
    {
        $stats = User::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('role', $role)
            ->whereBetween('created_at', [now()->subMonths(4)->startOfMonth(), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        $labels = [];
        $data = [];
        foreach ($stats as $stat) {
            $labels[] = $stat->date;
            $data[] = $stat->total;
        }
        $countThisMonth = $stats->sum('total');
        $lastFourMonthsCount = User::where('role', $role)
            ->whereBetween('created_at', [
                now()->subMonths(5)->startOfMonth(),
                now()->subMonths(1)->endOfMonth()
            ])->count();
        $trendIndicator = $countThisMonth >= $lastFourMonthsCount ? '↑' : '↓';
        return [
            'labels' => $labels,
            'data' => $data,
            'countThisMonth' => $countThisMonth,
            'trendIndicator' => $trendIndicator,
        ];
    }
}
