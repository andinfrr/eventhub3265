@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">

        <div>
            <h1 class="text-3xl font-black">
                Approval Event
            </h1>

            <p class="text-slate-500 font-medium">
                Setujui atau tolak event yang diajukan organisasi.
            </p>
        </div>

    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-black text-slate-700">
                            Poster
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-black text-slate-700">
                            Event
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-black text-slate-700">
                            Organisasi
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-black text-slate-700">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-black text-slate-700">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($events as $event)

                    <tr class="border-t border-slate-200 hover:bg-slate-50 transition">

                        <!-- POSTER -->
                        <td class="px-6 py-4">

                            <img
                                src="{{ $event->poster_path ? asset('storage/'.$event->poster_path) : 'https://placehold.co/80x100' }}"
                                class="w-16 h-20 rounded-xl object-cover">

                        </td>

                        <!-- EVENT -->
                        <td class="px-6 py-4">

                            <div class="font-bold text-slate-800">
                                {{ $event->title }}
                            </div>

                            <div class="text-sm text-slate-500">
                                {{ $event->date }}
                            </div>

                        </td>

                        <!-- ORGANISASI -->
                        <td class="px-6 py-4">

                            <div class="font-semibold">
                                {{ $event->organization->name ?? '-' }}
                            </div>

                        </td>

                        <!-- STATUS -->
                        <td class="px-6 py-4 text-center">

                            @if($event->status=='pending')

                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                    Pending
                                </span>

                            @elseif($event->status=='approved')

                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                    Approved
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                    Rejected
                                </span>

                            @endif

                        </td>

                        <!-- AKSI -->
                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                @if($event->status=='pending')

                                    <form action="{{ route('admin.events.approve',$event->id) }}" method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition">
                                            Approve
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.events.reject',$event->id) }}" method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition">
                                            Reject
                                        </button>

                                    </form>

                                @else

                                    <span class="text-slate-400">
                                        —
                                    </span>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center py-10 text-slate-500">

                            Belum ada event yang diajukan.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>

@endsection