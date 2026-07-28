@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')

<main class="max-w-4xl mx-auto px-6 py-20">

    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 p-10 text-center">

        {{-- Icon --}}
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">

            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="3"
                      d="M5 13l4 4L19 7" />

            </svg>

        </div>

        {{-- Title --}}
        <h1 class="text-4xl font-black text-slate-800 mb-3">

            Pembayaran Berhasil 🎉

        </h1>

        <p class="text-slate-500 mb-10">

            Terima kasih telah melakukan pembelian tiket di
            <span class="font-bold text-indigo-600">EventHub</span>.

        </p>

        {{-- Detail --}}
        <div class="bg-slate-50 rounded-2xl p-6 text-left space-y-4">

            <div class="flex justify-between">

                <span class="text-slate-500">
                    Order ID
                </span>

                <span class="font-bold">
                    {{ $transaction->order_id }}
                </span>

            </div>

            <div class="flex justify-between">

                <span class="text-slate-500">
                    Nama Peserta
                </span>

                <span class="font-bold">
                    {{ $transaction->customer_name }}
                </span>

            </div>

            <div class="flex justify-between">

                <span class="text-slate-500">
                    Event
                </span>

                <span class="font-bold">
                    {{ $transaction->event->title }}
                </span>

            </div>

            <div class="flex justify-between">

                <span class="text-slate-500">
                    Email
                </span>

                <span class="font-bold">
                    {{ $transaction->customer_email }}
                </span>

            </div>

            <div class="flex justify-between">

                <span class="text-slate-500">
                    Total Pembayaran
                </span>

                <span class="font-bold text-indigo-600">

                    Rp {{ number_format($transaction->total_price,0,',','.') }}

                </span>

            </div>

        </div>

        {{-- Informasi --}}
        <div class="mt-8">

            <p class="text-slate-500">

                E-Ticket telah dikirim ke email Anda.

                <br>

                Anda juga dapat mengunduh E-Certificate melalui tombol di bawah ini.

            </p>

        </div>

        {{-- Tombol --}}
        <div class="flex flex-wrap justify-center gap-4 mt-10">

            <a
                href="{{ route('certificate.generate', $transaction->id) }}"
                class="px-8 py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition">

                🏅 Download E-Certificate

            </a>

            <a
                href="{{ route('home') }}"
                class="px-8 py-4 rounded-2xl border border-slate-300 hover:bg-slate-100 font-bold transition">

                🏠 Kembali ke Beranda

            </a>

        </div>

    </div>

</main>

@endsection