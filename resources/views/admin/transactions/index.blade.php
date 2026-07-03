@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

<form method="GET" action="{{ route('transactions.index') }}">

    {{-- Header --}}
    <div class="bg-white rounded-[2rem] border border-slate-200 p-8 mb-6">

        <div class="flex justify-between items-start">

            <div>

                <p class="text-indigo-600 font-bold uppercase tracking-widest text-xs">
                    Transaction Management
                </p>

                <h1 class="text-3xl font-black text-slate-900 mt-2">
                    Laporan Transaksi
                </h1>

                <p class="text-slate-500 mt-2">
                    Kelola dan pantau seluruh transaksi pembelian tiket event.
                </p>

            </div>

            <div class="flex gap-3">

                <select
                    name="status"
                    class="px-5 py-3 rounded-xl border border-slate-200 bg-white">

                    <option value="">Semua Status</option>

                    <option value="Pending"
                        {{ request('status') == 'Pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="Success"
                        {{ request('status') == 'Success' ? 'selected' : '' }}>
                        Success
                    </option>

                </select>

                <select
                    name="month"
                    class="px-5 py-3 rounded-xl border border-slate-200 bg-white">

                    <option value="">Semua Periode</option>

                    <option value="this_month"
                        {{ request('month') == 'this_month' ? 'selected' : '' }}>
                        Bulan Ini
                    </option>

                    <option value="last_month"
                        {{ request('month') == 'last_month' ? 'selected' : '' }}>
                        Bulan Lalu
                    </option>

                </select>



            </div>

        </div>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden">

        {{-- Search --}}
      <div class="p-6 border-b bg-white">

    <div class="flex gap-3">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari Order ID, Nama Customer, atau Email..."
            class="flex-1 px-6 py-4 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">

        <button
            type="submit"
            class="px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700">

            Filter

        </button>

    </div>

</div>
        

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="bg-slate-100 text-slate-500 uppercase text-xs tracking-wider">

                        <th class="px-8 py-5 text-left">
                            Order ID
                        </th>

                        <th class="px-8 py-5 text-left">
                            Customer
                        </th>

                        <th class="px-8 py-5 text-left">
                            Event
                        </th>

                        <th class="px-8 py-5 text-left">
                            Tanggal
                        </th>

                        <th class="px-8 py-5 text-left">
                            Status
                        </th>

                        <th class="px-8 py-5 text-right">
                            Total
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($transactions as $trx)

                    <tr class="border-t border-slate-100 hover:bg-slate-50 transition">

                        <td class="px-8 py-6">

                            <span
                                class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-600 px-4 py-2 rounded-full text-xs font-bold">

                                🎫 {{ $trx->order_id }}

                            </span>

                        </td>

                        <td class="px-8 py-6">

                            <div class="font-bold text-slate-800">
                                {{ $trx->customer_name }}
                            </div>

                            <div class="text-xs text-slate-400 mt-1">
                                {{ $trx->customer_email }}
                            </div>

                            <div class="text-xs text-slate-400">
                                {{ $trx->customer_phone }}
                            </div>

                        </td>

                        <td class="px-8 py-6">

                            <div class="font-medium text-slate-700">
                                {{ $trx->event->title ?? '-' }}
                            </div>

                        </td>

                        <td class="px-8 py-6 text-sm text-slate-500">

                            {{ $trx->created_at->format('d M Y') }}

                            <div class="text-xs text-slate-400 mt-1">
                                {{ $trx->created_at->format('H:i') }}
                            </div>

                        </td>

                        <td class="px-8 py-6">

                            @if($trx->status == 'Success')

                                <span class="inline-flex items-center gap-2 text-green-600 font-bold">

                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>

                                    Success

                                </span>

                            @elseif($trx->status == 'Pending')

                                <span class="inline-flex items-center gap-2 text-orange-500 font-bold">

                                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>

                                    Pending

                                </span>

                            @else

                                <span class="inline-flex items-center gap-2 text-slate-500 font-bold">

                                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>

                                    {{ $trx->status }}

                                </span>

                            @endif

                        </td>

                        <td class="px-8 py-6 text-right">

                            <span class="text-lg font-black text-slate-900">

                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}

                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center py-16">

                            <div class="text-slate-400">

                                <p class="font-semibold text-lg">
                                    Belum Ada Transaksi
                                </p>

                                <p class="text-sm mt-2">
                                    Data transaksi akan muncul di sini.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</form>


</main>

@endsection
