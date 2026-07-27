<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::when(request('search'), function ($query) {
            $query->where('code', 'like', '%' . request('search') . '%');
        })
        ->latest()
        ->get();

        $totalCoupons = Coupon::count();

        $activeCoupons = Coupon::where('status', true)
        ->where(function ($query) {
            $query->whereNull('expired_at')
                ->orWhere('expired_at', '>=', now());
        })
        ->count();

        $expiredCoupons = Coupon::whereNotNull('expired_at')
            ->where('expired_at', '<', now())
            ->count();

        $usedCoupons = Coupon::sum('used');

        return view('admin.coupons.index', compact(
            'coupons',
            'totalCoupons',
            'activeCoupons',
            'expiredCoupons',
            'usedCoupons'
        ));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:coupons,code',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:1',
            'max_usage' => 'required|integer|min:1',
            'expired_at' => 'nullable|date',
            'status' => 'required|boolean',
        ]);

        if (
            $request->discount_type == 'percent' &&
            $request->discount_value > 100
        ) {
            return back()
                ->withErrors([
                    'discount_value' => 'Diskon maksimal 100%.'
                ])
                ->withInput();
        }

        Coupon::create($data);

        return redirect()
            ->route('coupons.index')
            ->with('success', 'Voucher berhasil ditambahkan.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:1',
            'max_usage' => 'required|integer|min:1',
            'expired_at' => 'nullable|date',
            'status' => 'required|boolean',
        ]);

        if (
            $request->discount_type == 'percent' &&
            $request->discount_value > 100
        ) {
            return back()
                ->withErrors([
                    'discount_value' => 'Diskon maksimal 100%.'
                ])
                ->withInput();
        }

        $coupon->update($data);

        return redirect()
            ->route('coupons.index')
            ->with('success', 'Voucher berhasil diubah.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return back()->with('success', 'Voucher berhasil dihapus.');
    }
}