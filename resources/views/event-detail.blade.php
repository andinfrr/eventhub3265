@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left: Poster -->
        <div class="lg:col-span-1">
            <div class="sticky top-32">
                <img src="{{ ($event->poster_path &&
                    Storage::disk('public')->exists($event->poster_path))
                    ? asset('storage/'.$event->poster_path)
                    : 'https://placehold.co/200x600' }}"
                    alt="{{ $event->title }}"
                    class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white">
                <div class="mt-8 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                    <h4 class="font-bold mb-4">Penyelenggara</h4>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                            AB</div>
                        <div>
                            <p class="font-bold text-slate-800">ABP Productions</p>
                            <p class="text-xs text-slate-500">Verified Organizer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Details -->
        <div class="lg:col-span-2 space-y-12">
            <div class="space-y-4">
                <span
                    class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">{{ $event->category->name }}</span>
                <h1 class="text-4xl md:text-5xl font-black leading-tight">{{ $event->title }}</h1>
                <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $event->location }}</span>
                    </div>
                </div>
            </div>

            <div class="prose prose-slate max-w-none">
                <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
                <p class="text-lg text-slate-600 leading-relaxed">
                   {{ $event->description }}
                </p>
            </div>

            <div
                class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>
                        <h2 class="text-5xl font-black">Rp {{ number_format($event->price,0,',','.') }} <span class="text-lg font-medium text-indigo-200">/
                                orang</span></h2>
                        <p class="mt-4 text-indigo-100 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Sisa stok: <span class="font-bold underline">{{ $event->stock }} Tiket lagi!</span>
                        </p>
                    </div>
                    <div>
						
                        <a href="{{ route('checkout.create', $event->id) }}"
                             class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                            Pesan Sekarang
                            </a>
                    </div>
                </div>
                <!-- Decoration -->
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
                <ul class="space-y-3 text-slate-500">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Tiket dapat discan di pintu masuk (Check-in).
                    </li>
                    <li class="flex items-start gap-2 text-rose-500">
                        <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tiket yang sudah dibeli tidak dapat direfund.
                    </li>
                </ul>
            </div>
           {{-- ========================================================= --}}
{{-- RATING & REVIEW --}}
{{-- ========================================================= --}}

<div class="bg-white rounded-[2rem] shadow-lg border border-slate-200 p-8 mt-10">

    <div class="flex items-center justify-between mb-8">

        <div>

            <h2 class="text-2xl font-black text-slate-800">
                Rating Event
            </h2>

            <p class="text-slate-500 mt-1">
                Bagikan pengalamanmu setelah mengikuti event ini.
            </p>

        </div>

        <div class="text-right">

            <h1 class="text-5xl font-black text-indigo-600">

                {{ $averageRating ? number_format($averageRating,1) : '0.0' }}

            </h1>

            <div class="text-yellow-400 text-xl">

                ⭐⭐⭐⭐⭐

            </div>

            <small class="text-slate-500">

                {{ $ratings->count() }} Review

            </small>

        </div>

    </div>

    {{-- ALERT --}}
    @if(session('success'))

        <div class="mb-5 bg-green-100 border border-green-300 text-green-700 rounded-xl px-5 py-3">

            {{ session('success') }}

        </div>

    @endif

    {{-- FORM RATING --}}
    @auth

    <form action="{{ route('ratings.store') }}" method="POST">

        @csrf

        <input type="hidden"
               name="event_id"
               value="{{ $event->id }}">

        <div class="mb-5">

            <label class="block font-bold mb-3">

                Berikan Rating

            </label>

            <div class="flex gap-2 mb-3">

    @for($i=1;$i<=5;$i++)

        <svg
            data-value="{{ $i }}"
            class="star w-10 h-10 cursor-pointer text-gray-300 transition hover:scale-110"
            fill="currentColor"
            viewBox="0 0 20 20">

            <path d="M9.049.927c.3-.921 1.603-.921 1.902 0l1.562 4.81a1 1 0 00.95.69h5.057c.969 0 1.371 1.24.588 1.81l-4.09 2.97a1 1 0 00-.364 1.118l1.562 4.81c.3.921-.755 1.688-1.54 1.118l-4.09-2.97a1 1 0 00-1.176 0l-4.09 2.97c-.784.57-1.838-.197-1.539-1.118l1.562-4.81a1 1 0 00-.364-1.118L.39 8.237c-.783-.57-.38-1.81.588-1.81h5.057a1 1 0 00.95-.69L9.05.927z"/>

        </svg>

    @endfor

</div>

<input
    type="hidden"
    name="rating"
    id="rating"
    required>
        </div>

        <div class="mb-6">

            <label class="block font-bold mb-2">

                Review

            </label>

            <textarea
                name="review"
                rows="4"
                class="w-full border border-slate-200 rounded-xl p-4 focus:ring-2 focus:ring-indigo-500"
                placeholder="Ceritakan pengalamanmu mengikuti event ini..."></textarea>

        </div>

        <button
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-bold transition">

            Kirim Rating

        </button>

    </form>

    @else

    <div class="bg-yellow-100 border border-yellow-300 rounded-2xl p-6">

        <h3 class="font-bold text-yellow-700 mb-2">

            Login Diperlukan

        </h3>

        <p class="text-yellow-700">

            Silakan login menggunakan akun Google untuk memberikan rating.

        </p>

        <a href="{{ route('google.login') }}"
           class="inline-block mt-4 px-5 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-bold">

            Login dengan Google

        </a>

    </div>

    @endauth

</div>

{{-- ========================================================= --}}
{{-- REVIEW PENGGUNA --}}
{{-- ========================================================= --}}

<div class="mt-12">

    <h2 class="text-2xl font-black mb-6">

        Review Pengunjung

    </h2>

    @forelse($ratings as $rating)

    <div class="bg-white rounded-3xl shadow border border-slate-100 p-6 mb-5">

        <div class="flex justify-between items-center">

            <div class="flex items-center gap-4">

                <img
                    src="{{ $rating->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($rating->user->name) }}"
                    class="w-12 h-12 rounded-full object-cover">

                <div>

                    <h4 class="font-bold">

                        {{ $rating->user->name }}

                    </h4>

                    <small class="text-slate-500">

                        {{ $rating->created_at->diffForHumans() }}

                    </small>

                </div>

            </div>

            <div class="text-yellow-400 text-xl">

                @for($i=1;$i<=5;$i++)

                    {{ $i <= $rating->rating ? '⭐' : '☆' }}

                @endfor

            </div>

        </div>

        @if($rating->review)

        <p class="mt-5 text-slate-600 italic">

            "{{ $rating->review }}"

        </p>

        @endif

    </div>

    @empty

    <div class="bg-slate-50 rounded-2xl border border-dashed border-slate-300 p-8 text-center">

        <div class="text-5xl mb-3">

            ⭐

        </div>

        <h3 class="font-bold text-lg">

            Belum Ada Review

        </h3>

        <p class="text-slate-500 mt-2">

            Jadilah orang pertama yang memberikan rating untuk event ini.

        </p>

    </div>

    @endforelse

</div>
        </div>
    </main>
    <script>

const stars = document.querySelectorAll(".star");
const ratingInput = document.getElementById("rating");

let currentRating = 0;

stars.forEach((star,index)=>{

    star.addEventListener("mouseover",()=>{

        stars.forEach((s,i)=>{

            s.classList.toggle("text-yellow-400",i<=index);
            s.classList.toggle("text-gray-300",i>index);

        });

    });

    star.addEventListener("click",()=>{

        currentRating=index+1;

        ratingInput.value=currentRating;

        stars.forEach((s,i)=>{

            s.classList.toggle("text-yellow-400",i<currentRating);
            s.classList.toggle("text-gray-300",i>=currentRating);

        });

    });

});

document.querySelector(".star").parentElement.parentElement.addEventListener("mouseleave",()=>{

    stars.forEach((s,i)=>{

        s.classList.toggle("text-yellow-400",i<currentRating);
        s.classList.toggle("text-gray-300",i>=currentRating);

    });

});

</script>
@endsection