@extends('layouts.admin')

@section('content')

<main class="flex-1 p-10 overflow-y-auto">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">

        <div>
            <h1 class="text-3xl font-black">
                Manajemen Organisasi
            </h1>

            <p class="text-slate-500 font-medium">
                Kelola organisasi penyelenggara event
            </p>
        </div>

    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <!-- TABLE HEAD -->
                <thead class="bg-slate-100">
                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-black text-slate-700">
                            ID
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-black text-slate-700">
                            Nama Organisasi
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-black text-slate-700">
                            Email
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-black text-slate-700">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-black text-slate-700">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <!-- TABLE BODY -->
                <tbody>

                @forelse($organizations as $org)

                    <tr class="border-t border-slate-200 hover:bg-slate-50 transition">

                        <!-- ID -->
                        <td class="px-6 py-4 text-sm text-slate-700">
                            {{ $org->id }}
                        </td>

                        <!-- NAME -->
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">
                                {{ $org->name }}
                            </div>
                        </td>

                        <!-- EMAIL -->
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $org->email }}
                        </td>

                        <!-- STATUS -->
                        <td class="px-6 py-4 text-center">

                            @if($org->status == 'pending')

                                <span class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                    Pending
                                </span>

                            @elseif($org->status == 'approved')

                                <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                    Approved
                                </span>

                            @else

                                <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                    Rejected
                                </span>

                            @endif

                        </td>

                        <!-- ACTION -->
                        <td class="px-6 py-4">

                            @if($org->status == 'pending')

                                <div class="flex justify-center gap-2">

                                    <form
                                        action="{{ route('organizations.approve', $org->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Yakin ingin menyetujui organisasi ini?')"
                                            class="px-4 py-2 bg-green-50 text-green-700 rounded-xl hover:bg-green-600 hover:text-white transition font-semibold">
                                            Approve
                                        </button>

                                    </form>

                                    <form
                                        action="{{ route('organizations.reject', $org->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Yakin ingin menolak organisasi ini?')"
                                            class="px-4 py-2 bg-red-50 text-red-700 rounded-xl hover:bg-red-600 hover:text-white transition font-semibold">
                                            Reject
                                        </button>

                                    </form>

                                </div>

                            @else

                                <div class="text-center text-slate-400 font-semibold">
                                    —
                                </div>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada organisasi yang mendaftar.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>

@endsection