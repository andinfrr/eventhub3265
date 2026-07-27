@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">

        <div>
            <h1 class="text-3xl font-black">
                Manajemen Voucher
            </h1>

            <p class="text-slate-500 font-medium">
                Kelola voucher diskon untuk event.
            </p>
        </div>

        <div class="flex flex-col md:flex-row gap-3">

            <!-- SEARCH -->
            <form
                action="{{ route('coupons.index') }}"
                method="GET"
                class="flex gap-2">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kode voucher..."
                    class="px-4 py-3 border border-slate-300 rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500">

                <button
                    type="submit"
                    class="px-5 py-3 bg-slate-800 text-white rounded-2xl font-bold hover:bg-slate-900 transition">

                    Cari

                </button>

            </form>

            <!-- BUTTON -->
            <a
                href="{{ route('coupons.create') }}"
                class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition text-center">

                + Tambah Voucher

            </a>

        </div>

    </div>

    <!-- SUCCESS -->
    @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl font-medium">
            {{ session('success') }}
        </div>

    @endif

    <!-- STATISTIC -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

        <div class="bg-white rounded-3xl border border-slate-200 p-6">
            <p class="text-slate-500 text-sm">
                Total Voucher
            </p>

            <h2 class="text-3xl font-black mt-2">
                {{ $totalCoupons }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6">
            <p class="text-slate-500 text-sm">
                Voucher Aktif
            </p>

            <h2 class="text-3xl font-black text-green-600 mt-2">
                {{ $activeCoupons }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6">
            <p class="text-slate-500 text-sm">
                Voucher Expired
            </p>

            <h2 class="text-3xl font-black text-red-600 mt-2">
                {{ $expiredCoupons }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6">
            <p class="text-slate-500 text-sm">
                Total Digunakan
            </p>

            <h2 class="text-3xl font-black text-indigo-600 mt-2">
                {{ $usedCoupons }}
            </h2>
        </div>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-black">
                            ID
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-black">
                            Kode
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-black">
                            Jenis
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-black">
                            Diskon
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-black">
                            Max Usage
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-black">
                            Used
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-black">
                            Expired
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-black">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-black">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($coupons as $coupon)

                        <tr class="border-t border-slate-200 hover:bg-slate-50">

                            <td class="px-6 py-4">
                                {{ $coupon->id }}
                            </td>

                            <td class="px-6 py-4 font-bold">
                                {{ $coupon->code }}
                            </td>

                            <td class="px-6 py-4">

                                @if($coupon->discount_type == 'percent')

                                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                                        Persentase
                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-bold">
                                        Nominal
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4 font-semibold">

                                @if($coupon->discount_type == 'percent')

                                    {{ $coupon->discount_value }} %

                                @else

                                    Rp {{ number_format($coupon->discount_value,0,',','.') }}

                                @endif

                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ $coupon->max_usage }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ $coupon->used }}
                            </td>

                            <td class="px-6 py-4 text-center">

                                @if($coupon->expired_at)

                                    {{ \Carbon\Carbon::parse($coupon->expired_at)->format('d M Y') }}

                                @else

                                    -

                                @endif

                            </td>

                           <td class="px-6 py-4 text-center">

                                @if($coupon->expired_at && $coupon->expired_at < now())

                                    <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                                        Expired
                                    </span>

                                @elseif($coupon->status)

                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                        Aktif
                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                        Nonaktif
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a
                                        href="{{ route('coupons.edit',$coupon->id) }}"
                                        class="px-3 py-2 rounded-xl bg-indigo-100 text-indigo-700 hover:bg-indigo-600 hover:text-white transition">

                                        Edit

                                    </a>

                                    <form
                                        action="{{ route('coupons.destroy',$coupon->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Yakin ingin menghapus voucher?')"
                                            class="px-3 py-2 rounded-xl bg-red-100 text-red-700 hover:bg-red-600 hover:text-white transition">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" class="text-center py-10 text-slate-500">

                                Belum ada voucher.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>

@endsection