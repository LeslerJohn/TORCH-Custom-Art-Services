<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ArtistProfile;
use App\Models\Commission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    public function index()
    {
        $artistStats = $this->getUserStats('artist');
        $clientStats = $this->getUserStats('client');
        $applicationStats = $this->getApplicationStats();
        $monthlyArtistStats = $this->getMonthlyArtistStats(now()->year);
        $transactionsMonthly = $this->getMonthlyTransactionsStats(now()->year);

        // Return the data to the view
        return view('admin.dashboard', [
            'artistLabels' => $artistStats['labels'],
            'artistData' => $artistStats['data'],
            'artistsCountThisMonth' => $artistStats['countThisMonth'],
            'artistTrendIndicator' => $artistStats['trendIndicator'],

            'clientLabels' => $clientStats['labels'],
            'clientData' => $clientStats['data'],
            'clientsCountThisMonth' => $clientStats['countThisMonth'],
            'clientTrendIndicator' => $clientStats['trendIndicator'],

            'chartLabels' => $applicationStats['labels'],
            'chartData' => $applicationStats['data'],
            'averageRange' => $applicationStats['averageRange'],

            'monthlyArtistLabels' => $monthlyArtistStats['labels'],
            'monthlyArtistData' => $monthlyArtistStats['data'],
            'latestArtistCount' => $monthlyArtistStats['latestCount'],
            'artistPercentageChange' => $monthlyArtistStats['percentageChange'],
            'artistTrendIndicator' => $monthlyArtistStats['trendIndicator'],

            'monthlyTransactionsLabels' => $transactionsMonthly['labels'],
            'monthlyTransactionsData' => $transactionsMonthly['data'],
            'latestTransactionsCount' => $transactionsMonthly['latestCount'],
            'transactionsPercentageChange' => $transactionsMonthly['percentageChange'],
            'transactionsTrendIndicator' => $transactionsMonthly['trendIndicator'],
            
        ]);
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

    private function getMonthlyArtistStats($year)
    {
        $artistsMonthly = User::select(DB::raw('strftime("%m", created_at) as month_number'), DB::raw('strftime("%m", created_at) as month'), DB::raw('strftime("%Y", created_at) as year'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $year)
            ->groupBy('year', 'month', 'month_number')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];
        foreach ($artistsMonthly as $row) {
            // Convert the numeric month (1..12) to a word
            $monthName = Carbon::createFromFormat('m', $row->month_number)->format('M');
            // e.g. if month_number = 1 -> "January"

            $labels[] = $monthName;
            $data[] = $row->total;
        }

        $latestCount = end($data) ?: 0;
        $dataCount = count($data);
        if ($dataCount > 1) {
            $previousCount = $data[$dataCount - 2];
            $difference = $latestCount - $previousCount;
            $percentageChange = ($previousCount == 0) ? 0 : ($difference / $previousCount) * 100;
        } else {
            $percentageChange = 0;
        }
        $trendIndicator = ($percentageChange >= 0) ? '↑' : '↓';

        return [
            'labels' => $labels,
            'data' => $data,
            'latestCount' => $latestCount,
            'percentageChange' => round($percentageChange),
            'trendIndicator' => $trendIndicator,
        ];
    }

    private function getMonthlyTransactionsStats($year)
    {
        $transactionsMonthly = Commission::select(DB::raw('strftime("%m", created_at) as month_number'), DB::raw('strftime("%m", created_at) as month'), DB::raw('strftime("%Y", created_at) as year'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $year)
            ->groupBy('year', 'month', 'month_number')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];
        foreach ($transactionsMonthly as $row) {
            // Convert the numeric month (1..12) to a word
            $monthName = Carbon::createFromFormat('m', $row->month_number)->format('M');
            // e.g. if month_number = 1 -> "January"

            $labels[] = $monthName;
            $data[] = $row->total;
        }

        $latestCount = end($data) ?: 0;
        $dataCount = count($data);
        if ($dataCount > 1) {
            $previousCount = $data[$dataCount - 2];
            $difference = $latestCount - $previousCount;
            $percentageChange = ($previousCount == 0) ? 0 : ($difference / $previousCount) * 100;
        } else {
            $percentageChange = 0;
        }
        $trendIndicator = ($percentageChange >= 0) ? '↑' : '↓';

        return [
            'labels' => $labels,
            'data' => $data,
            'latestCount' => $latestCount,
            'percentageChange' => round($percentageChange),
            'trendIndicator' => $trendIndicator,
        ];
    }

    public function exportStatistics(Request $request)
    {
        $type = $request->query('type', 'artists'); // Default to 'artists'
        $data = [];
        $headers = [];

        switch ($type) {
            case 'artists':
                $data = $this->getUserStats('artist');
                $headers = ['Date', 'Total Artists'];
                break;
            case 'clients':
                $data = $this->getUserStats('client');
                $headers = ['Date', 'Total Clients'];
                break;
            case 'applications':
                $data = $this->getApplicationStats();
                $headers = ['Status', 'Total Applications'];
                break;
            case 'transactions':
                $data = $this->getMonthlyTransactionsStats(now()->year);
                $headers = ['Month', 'Total Transactions'];
                break;
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }

        $csvData = implode(',', $headers) . "\n";

        foreach ($data['labels'] as $index => $label) {
            $csvData .= $label . ',' . $data['data'][$index] . "\n";
        }

        $filename = "{$type}_statistics_" . now()->format('Y-m-d') . ".csv";

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function exportAllStatistics()
    {
        $sections = [
            'artists' => $this->getUserStats('artist'),
            'clients' => $this->getUserStats('client'),
            'applications' => $this->getApplicationStats(),
            'transactions' => $this->getMonthlyTransactionsStats(now()->year),
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

        $filename = "all_statistics_" . now()->format('Y-m-d') . ".csv";

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
