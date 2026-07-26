<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $organizationId = auth()->user()->organization_id;

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

        $recentTransactions = Transaction::with('event')
            ->where('organization_id', $organizationId)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalRevenue', 'ticketsSold', 'activeEvents', 'pendingOrders', 'recentTransactions'));
    }
}