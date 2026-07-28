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
    $user = auth()->user();

    $isSuperAdmin = $user->role === 'superadmin';

    // Query dasar
    $transactionQuery = Transaction::query();
    $eventQuery = Event::query();
    $userQuery = User::query();

    // Kalau admin organisasi, filter berdasarkan organization_id
    if (!$isSuperAdmin) {
        $transactionQuery->where('organization_id', $user->organization_id);
        $eventQuery->where('organization_id', $user->organization_id);
        $userQuery->where('organization_id', $user->organization_id);
    }

    // ==========================
    // CARD DASHBOARD
    // ==========================

    $totalRevenue = (clone $transactionQuery)
        ->whereIn('status', ['settlement', 'success'])
        ->sum('total_price');

    $ticketsSold = (clone $transactionQuery)
        ->whereIn('status', ['settlement', 'success'])
        ->count();

    $activeEvents = (clone $eventQuery)
        ->where('date', '>=', now())
        ->count();

    $pendingOrders = (clone $transactionQuery)
        ->where('status', 'pending')
        ->count();

    $totalUsers = $isSuperAdmin
        ? User::count()
        : (clone $userQuery)->count();

    // ==========================
    // TRANSAKSI TERBARU
    // ==========================

    $recentTransactions = (clone $transactionQuery)
        ->with('event')
        ->latest()
        ->take(5)
        ->get();

    // ==========================
    // PENDAPATAN PER BULAN
    // ==========================

    $monthlyRevenue = (clone $transactionQuery)
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total')
        )
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

    $popularEvents = Transaction::join('events', 'transactions.event_id', '=', 'events.id')
        ->select(
            'events.title',
            DB::raw('COUNT(transactions.id) as total')
        )
        ->when(!$isSuperAdmin, function ($q) use ($user) {
            $q->where('transactions.organization_id', $user->organization_id);
        })
        ->whereIn('transactions.status', ['settlement', 'success'])
        ->groupBy('events.title')
        ->orderByDesc('total')
        ->take(5)
        ->get();

    // ==========================
    // STATUS TRANSAKSI
    // ==========================

    $statusChart = (clone $transactionQuery)
        ->select(
            'status',
            DB::raw('COUNT(*) as total')
        )
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

    $ratingEvents = Event::leftJoin('ratings', 'events.id', '=', 'ratings.event_id')
        ->select(
            'events.id',
            'events.title',
            DB::raw('AVG(ratings.rating) as average_rating'),
            DB::raw('COUNT(ratings.id) as total_review')
        )
        ->when(!$isSuperAdmin, function ($q) use ($user) {
            $q->where('events.organization_id', $user->organization_id);
        })
        ->groupBy('events.id', 'events.title')
        ->orderByDesc('average_rating')
        ->take(3)
        ->get();

    // ==========================
    // EVENT HAMPIR SOLD OUT
    // ==========================

    $lowStockEvents = (clone $eventQuery)
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