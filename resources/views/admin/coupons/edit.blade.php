@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <div class="max-w-3xl mx-auto">

        <!-- TITLE -->
        <div class="mb-8">

            <h1 class="text-3xl font-black mb-2">
                Edit Voucher
            </h1>

            <p class="text-slate-500">
                Perbarui data voucher diskon.
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

            <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">

                @csrf
                @method('PUT')

                <!-- CODE -->
                <div class="mb-6">

                    <label class="block mb-2 font-bold">
                        Kode Voucher
                    </label>

                    <input
                        type="text"
                        name="code"
                        value="{{ old('code', $coupon->code) }}"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl">

                </div>

                <!-- TYPE -->
                <div class="mb-6">

                    <label class="block mb-2 font-bold">
                        Jenis Diskon
                    </label>

                    <select
                        name="discount_type"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl">

                        <option value="percent"
                            {{ old('discount_type', $coupon->discount_type) == 'percent' ? 'selected' : '' }}>
                            Persentase (%)
                        </option>

                        <option value="fixed"
                            {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>
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
                        value="{{ old('discount_value', $coupon->discount_value) }}"
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
                        value="{{ old('max_usage', $coupon->max_usage) }}"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl">

                </div>

                <!-- USED -->
                <div class="mb-6">

                    <label class="block mb-2 font-bold">
                        Sudah Digunakan
                    </label>

                    <input
                        type="number"
                        value="{{ $coupon->used }}"
                        class="w-full px-5 py-3 border border-slate-300 rounded-2xl bg-slate-100"
                        readonly>

                </div>

                <!-- EXPIRED -->
                <div class="mb-6">

                    <label class="block mb-2 font-bold">
                        Tanggal Expired
                    </label>

                    <input
                        type="datetime-local"
                        name="expired_at"
                        value="{{ old('expired_at', $coupon->expired_at ? \Carbon\Carbon::parse($coupon->expired_at)->format('Y-m-d\TH:i') : '') }}"
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

                        <option value="1"
                            {{ old('status', $coupon->status) ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0"
                            {{ !old('status', $coupon->status) ? 'selected' : '' }}>
                            Nonaktif
                        </option>

                    </select>

                </div>

                <!-- BUTTON -->
                <div class="flex gap-3">

                    <button
                        type="submit"
                        class="px-6 py-3 bg-yellow-500 text-white rounded-2xl font-bold hover:bg-yellow-600">

                        Update

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