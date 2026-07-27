<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $organizationId = auth()->user()->organization_id;

        // ==========================
        // CARD DASHBOARD
        // ==========================

        $totalRevenue = Transaction::where('organization_id', $organizationId)
            ->whereIn('status', ['settlement', 'success'])
            ->sum('total_price');

        $ticketsSold = Transaction::where('organization_id', $organizationId)
            ->whereIn('status', ['settlement', 'success'])
            ->count();

        $activeEvents = Event::where('organization_id', $organizationId)
            ->where('date', '>=', now())
            ->count();

        $pendingOrders = Transaction::where('organization_id', $organizationId)
            ->where('status', 'pending')
            ->count();

        $totalUsers = User::where('organization_id', $organizationId)->count();

        // ==========================
        // TRANSAKSI TERBARU
        // ==========================

        $recentTransactions = Transaction::with('event')
            ->where('organization_id', $organizationId)
            ->latest()
            ->take(5)
            ->get();

        // ==========================
        // PENDAPATAN PER BULAN
        // ==========================

        $monthlyRevenue = Transaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->where('organization_id', $organizationId)
            ->whereIn('status', ['settlement', 'success'])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthLabels = [];
        $monthRevenue = [];

        foreach ($monthlyRevenue as $item) {
            $monthLabels[] = date('M', mktime(0, 0, 0, $item->month, 1));
            $monthRevenue[] = $item->total;
        }

        // ==========================
        // EVENT TERPOPULER
        // ==========================

        $popularEvents = Transaction::select(
                'events.title',
                DB::raw('COUNT(transactions.id) as total')
            )
            ->join('events', 'transactions.event_id', '=', 'events.id')
            ->where('transactions.organization_id', $organizationId)
            ->whereIn('transactions.status', ['settlement', 'success'])
            ->groupBy('events.title')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // ==========================
        // STATUS TRANSAKSI
        // ==========================

        $statusChart = Transaction::select(
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->where('organization_id', $organizationId)
            ->groupBy('status')
            ->get();

        // ==========================
        // STATISTIK RATING
        // ==========================

        $ratingChart = DB::table('ratings')
            ->select(
                'rating',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('rating')
            ->orderBy('rating')
            ->get();

        // ==========================
        // EVENT RATING TERTINGGI
        // ==========================

        $ratingEvents = Event::select(
                'events.id',
                'events.title',
                DB::raw('AVG(ratings.rating) as average_rating'),
                DB::raw('COUNT(ratings.id) as total_review')
            )
            ->leftJoin('ratings', 'events.id', '=', 'ratings.event_id')
            ->where('events.organization_id', $organizationId)
            ->groupBy('events.id', 'events.title')
            ->orderByDesc('average_rating')
            ->take(3)
            ->get();

        // ==========================
        // EVENT HAMPIR SOLD OUT
        // ==========================

        $lowStockEvents = Event::where('organization_id', $organizationId)
            ->orderBy('stock')
            ->take(5)
            ->get();

        // ==========================
        // INSIGHT
        // ==========================

        $bestEvent = $popularEvents->first();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'totalUsers',

            'recentTransactions',

            'monthLabels',
            'monthRevenue',

            'popularEvents',

            'statusChart',

            'ratingChart',

            'ratingEvents',

            'lowStockEvents',

            'bestEvent'
        ));
    }
}