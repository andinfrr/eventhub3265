<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  public function index(Request $request)
{
    $query = Transaction::with(['event', 'organization']);

    // Kalau bukan super admin, hanya lihat transaksi organisasinya sendiri
    if (auth()->user()->role !== 'superadmin') {
        $query->where('organization_id', auth()->user()->organization_id);
    }

    // SEARCH
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('order_id', 'like', '%' . $request->search . '%')
              ->orWhere('customer_name', 'like', '%' . $request->search . '%')
              ->orWhere('customer_email', 'like', '%' . $request->search . '%');
        });
    }

    // STATUS
    if ($request->filled('status') && $request->status != 'all') {
        $query->where('status', $request->status);
    }

    // BULAN
    if ($request->month == 'this_month') {
        $query->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year);
    }

    if ($request->month == 'last_month') {
        $lastMonth = now()->subMonth();

        $query->whereMonth('created_at', $lastMonth->month)
              ->whereYear('created_at', $lastMonth->year);
    }

    $transactions = $query
        ->latest()
        ->paginate(20)
        ->withQueryString();

    return view('admin.transactions.index', compact('transactions'));
}
}