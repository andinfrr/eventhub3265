@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <div class="max-w-3xl mx-auto">

        <!-- TITLE -->
        <div class="mb-8">

            <h1 class="text-3xl font-black mb-2">
                Tambah Voucher
            </h1>

            <p class="text-slate-500">
                Tambahkan voucher diskon baru.
            </p>

        </div>

        <!-- ERROR -->
        @if ($errors->any())

            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl">

                <ul class="list-disc pl-5 space-y-1">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

        <!-- CARD -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">

            <form action="{{ route('coupons.store') }}" method="POST">

                @csrf

                <!-- CODE -->
                <div class="mb-6">

                    <label class="block mb-2 font-bold">
                        Kode Voucher
                    </label>

                    <input
                        type="text"
                        name="code"
                        value="{{ old('code') }}"
                        placeholder="Contoh : MAHASISWA50"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-indigo-500">

                </div>

                <!-- TYPE -->
                <div class="mb-6">

                    <label class="block mb-2 font-bold">
                        Jenis Diskon
                    </label>

                    <select
                        name="discount_type"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl">

                        <option value="percent">
                            Persentase (%)
                        </option>

                        <option value="fixed">
                            Nominal (Rp)
                        </option>

                    </select>

                </div>

                <!-- VALUE -->
                <div class="mb-6">

                    <label class="block mb-2 font-bold">
                        Nilai Diskon
                    </label>

                    <input
                        type="number"
                        name="discount_value"
                        value="{{ old('discount_value') }}"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl">

                </div>

                <!-- MAX -->
                <div class="mb-6">

                    <label class="block mb-2 font-bold">
                        Maksimal Penggunaan
                    </label>

                    <input
                        type="number"
                        name="max_usage"
                        value="{{ old('max_usage',1) }}"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl">

                </div>

                <!-- EXPIRED -->
                <div class="mb-6">

                    <label class="block mb-2 font-bold">
                        Tanggal Expired
                    </label>

                    <input
                        type="datetime-local"
                        name="expired_at"
                        value="{{ old('expired_at') }}"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl">

                </div>

                <!-- STATUS -->
                <div class="mb-8">

                    <label class="block mb-2 font-bold">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl">

                        <option value="1">
                            Aktif
                        </option>

                        <option value="0">
                            Nonaktif
                        </option>

                    </select>

                </div>

                <!-- BUTTON -->
                <div class="flex gap-3">

                    <button
                        type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700">

                        Simpan

                    </button>

                    <a
                        href="{{ route('coupons.index') }}"
                        class="px-6 py-3 bg-slate-200 rounded-2xl font-bold">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</main>

@endsection