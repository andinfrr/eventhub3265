     @extends('layouts.admin')
     @section('title', 'Admin Dashboard')
     @section('page_title', 'Dashboard Ringkasan')

     @section('content')
     <!-- Stats Grid -->
     

     <!-- Latest Sales Table -->
     <div class="w-full bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

     <div class="mb-6">

    <div class="bg-gradient-to-r from-indigo-600 to-violet-600 rounded-3xl p-8 text-white shadow-lg">

    <div class="flex items-center justify-between">

        <div>

            <p class="uppercase tracking-widest text-indigo-200 text-sm">
                Total Pendapatan
            </p>

            <h1 class="text-5xl font-black mt-2">
                Rp {{ number_format($totalRevenue,0,',','.') }}
            </h1>

            <p class="mt-3 text-indigo-100">
                Total pemasukan dari seluruh transaksi berhasil.
            </p>

        </div>

        <div class="flex items-center gap-4">

            <div class="text-right">

                <h3 class="font-bold text-xl">
                    AmikomEventHub
                </h3>

                <p class="text-indigo-200 text-sm">
                    Admin Dashboard
                </p>

            </div>

            <div
                class="w-16 h-16 rounded-full bg-white text-indigo-600 font-black text-2xl flex items-center justify-center">

                AH

            </div>

        </div>

    </div>

</div>

</div>
    <div class="mt-100 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
         <!-- <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                     </path>
                 </svg>
             </div>
             <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total Pendapatan</p>
             <h3 class="text-2xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
         </div> -->

         <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                     </path>
                 </svg>
             </div>
             <p class="text-slate-400 text-sm font-bold uppercase mb-1">Tiket Terjual</p>
             <h3 class="text-2xl font-black">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
         </div>
         <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                 </svg>
             </div>
             <p class="text-slate-400 text-sm font-bold uppercase mb-1">Event Aktif</p>
             <h3 class="text-2xl font-black">{{ $activeEvents }} Event</h3>
         </div>
         <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
             <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-4">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                 </svg>
             </div>
             <p class="text-slate-400 text-sm font-bold uppercase mb-1">Pesanan Pending</p>
             <h3 class="text-2xl font-black">{{ $pendingOrders }} Pesanan</h3>
         </div>
     </div>
{{-- ============================= --}}
{{-- DASHBOARD ANALYTICS --}}
{{-- ============================= --}}

{{-- ROW 1 --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Pendapatan --}}
    <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

        <div class="flex justify-between items-center mb-6">

            <div>
                <h2 class="text-xl font-black">
                    📈 Pendapatan Bulanan
                </h2>

                <p class="text-sm text-slate-500">
                    Total pendapatan transaksi berhasil
                </p>
            </div>

            <span class="px-4 py-2 rounded-full bg-indigo-100 text-indigo-600 text-sm font-bold">
                {{ now()->year }}
            </span>

        </div>

        <canvas id="revenueChart" height="120"></canvas>

    </div>

    {{-- Status --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

        <h2 class="text-xl font-black mb-5">

            💳 Status Transaksi

        </h2>

        <div class="h-[320px] flex items-center justify-center">

            <canvas id="statusChart"></canvas>

        </div>

    </div>

</div>


{{-- ROW 2 --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Top Event --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

        <div class="flex justify-between items-center mb-5">

            <h2 class="text-xl font-black">

                🏆 Event Terlaris

            </h2>

            <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">
                Top 5
            </span>

        </div>

        <canvas id="eventChart" height="180"></canvas>

    </div>


    {{-- Rating --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

        <div class="flex justify-between items-center mb-5">

            <h2 class="text-xl font-black">

                ⭐ Rating Event

            </h2>

            <span class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                Review

            </span>

        </div>

        <canvas id="ratingChart" height="180"></canvas>

    </div>

</div>


{{-- ROW 3 --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-xl font-black">

            🔥 Event Hampir Sold Out

        </h2>

        <span class="text-sm text-red-500 font-semibold">

            Stok Menipis

        </span>

    </div>

    <div class="space-y-5">

        @forelse($lowStockEvents as $event)

            @php

                $sold = max(5,100-($event->stock/200*100));

            @endphp

            <div>

                <div class="flex justify-between mb-2">

                    <span class="font-semibold">

                        {{ $event->title }}

                    </span>

                    <span class="font-bold text-red-500">

                        {{ $event->stock }} tiket

                    </span>

                </div>

                <div class="w-full h-3 bg-slate-200 rounded-full">

                    <div
                        class="bg-gradient-to-r from-red-500 to-orange-500 h-3 rounded-full"
                        style="width:{{ $sold }}%">
                    </div>

                </div>

            </div>

        @empty

            <div class="text-center py-10 text-slate-400">

                Tidak ada event dengan stok rendah.

            </div>

        @endforelse

    </div>

</div>

         <div class="p-8 border-b flex justify-between items-center">
             <h3 class="font-black text-xl">Transaksi Terakhir</h3>
             <a href="{{ route('transactions.index') }}" class="text-indigo-600 font-bold hover:underline">Lihat Semua</a>
         </div>
         <div class="overflow-x-auto">
             <table class="w-full text-left border-collapse">
                 <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                     <tr>
                         <th class="px-8 py-4 w-1/4">Tgl Transaksi</th>
                         <th class="px-8 py-4 w-1/4">Pembeli</th>
                         <th class="px-8 py-4 w-1/4">Event</th>
                         <th class="px-8 py-4 w-[10%]">Status</th>
                         <th class="px-8 py-4 text-right">Total</th>
                     </tr>
                 </thead>
                 <tbody class="divide-y border-t">
                     @forelse($recentTransactions as $trx)
                     <tr class="hover:bg-slate-50 transition">
                         <td class="px-8 py-6 text-sm text-slate-600 max-w-xs break-all">{{ $trx->created_at->format('d M y - H:i') }}<br><span class="text-xs text-slate-400">{{ $trx->order_id }}</span></td>
                         <td class="px-8 py-6">
                             <p class="font-bold uppercase tracking-wide text-sm truncate max-w-[150px]">{{ $trx->customer_name }}</p>
                             <p class="text-xs text-slate-400 truncate max-w-[150px]">{{ $trx->customer_email }}</p>
                         </td>
                         <td class="px-8 py-6 font-medium text-slate-600 max-w-xs truncate">{{ $trx->event->title ?? '-' }}</td>
                         <td class="px-8 py-6 whitespace-nowrap">
                             @if($trx->status === 'settlement' || $trx->status === 'success')
                                 <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">Success</span>
                             @elseif($trx->status === 'pending')
                                 <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase">Pending</span>
                             @else
                                 <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase">{{ $trx->status }}</span>
                             @endif
                         </td>
                         <td class="px-8 py-6 font-black text-indigo-600 whitespace-nowrap text-right">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                     </tr>
                     @empty
                     <tr>
                         <td colspan="5" class="px-8 py-10 text-center text-slate-500">Belum ada transaksi</td>
                     </tr>
                     @endforelse
                 </tbody>
             </table>
         </div>
     </div>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// ==========================
// Pendapatan per Bulan
// ==========================

new Chart(document.getElementById('revenueChart'), {

    type: 'line',

    data: {

        labels: @json($monthLabels),

        datasets: [{

            label: 'Pendapatan',

            data: @json($monthRevenue),

            borderColor: '#4F46E5',

            backgroundColor: 'rgba(79,70,229,0.15)',

            fill: true,

            tension: 0.4,

            borderWidth: 3,

            pointRadius: 4,

            pointBackgroundColor: '#4F46E5'

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                display: false

            }

        },

        scales: {

            y: {

                beginAtZero: true

            }

        }

    }

});


// ==========================
// Status Transaksi
// ==========================

new Chart(document.getElementById('statusChart'), {

    type: 'doughnut',

    data: {

        labels: @json($statusChart->pluck('status')),

        datasets: [{

            data: @json($statusChart->pluck('total')),

            backgroundColor: [

                '#22C55E',

                '#FACC15',

                '#EF4444',

                '#6366F1',

                '#0EA5E9'

            ],

            borderWidth: 0

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                position: 'bottom'

            }

        }

    }

});


// ==========================
// Top Event Terlaris
// ==========================

new Chart(document.getElementById('eventChart'), {

    type: 'bar',

    data: {

        labels: @json($popularEvents->pluck('title')),

        datasets: [{

            label: 'Tiket Terjual',

            data: @json($popularEvents->pluck('total')),

            backgroundColor: '#6366F1',

            borderRadius: 12

        }]

    },

    options: {

        responsive: true,

        indexAxis: 'y',

        plugins: {

            legend: {

                display: false

            }

        },

        scales: {

            x: {

                beginAtZero: true

            }

        }

    }

});


// ==========================
// Statistik Rating
// ==========================

new Chart(document.getElementById('ratingChart'), {

    type: 'bar',

    data: {

        labels: @json($ratingChart->pluck('rating')),

        datasets: [{

            label: 'Jumlah Review',

            data: @json($ratingChart->pluck('total')),

            backgroundColor: '#FACC15',

            borderRadius: 10

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                display: false

            }

        },

        scales: {

            y: {

                beginAtZero: true

            }

        }

    }

});

</script>
     @endsection