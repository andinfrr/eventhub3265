<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Organisasi - AmikomEventHub</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        body{
            font-family:'Plus Jakarta Sans',sans-serif;
        }
    </style>

</head>

<body class="bg-indigo-900 min-h-screen flex items-center justify-center p-6">

<div class="max-w-3xl w-full bg-white rounded-[2rem] shadow-2xl p-10">

    <!-- HEADER -->
    <div class="text-center mb-10">

        <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white text-2xl font-black mx-auto mb-5">
            AH
        </div>

        <h1 class="text-3xl font-black text-slate-900">
            Registrasi Organisasi
        </h1>

        <p class="text-slate-500 mt-2">
            Daftarkan organisasi Anda untuk menjadi penyelenggara event di AmikomEventHub.
        </p>

    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())

        <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl">

            <ul class="list-disc ml-5 space-y-1">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('organization.store') }}" method="POST">

        @csrf

        <!-- ORGANISASI -->
        <h2 class="font-black text-lg mb-5 text-slate-800">
            Data Organisasi
        </h2>

        <div class="grid md:grid-cols-2 gap-6 mb-8">

            <div>

                <label class="block mb-2 font-bold text-sm text-slate-700">
                    Nama Organisasi
                </label>

                <input
                    type="text"
                    name="organization_name"
                    value="{{ old('organization_name') }}"
                    class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 bg-slate-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 outline-none">

            </div>

            <div>

                <label class="block mb-2 font-bold text-sm text-slate-700">
                    Email Organisasi
                </label>

                <input
                    type="email"
                    name="organization_email"
                    value="{{ old('organization_email') }}"
                    class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 bg-slate-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 outline-none">

            </div>

        </div>

        <!-- ADMIN -->
        <h2 class="font-black text-lg mb-5 text-slate-800">
            Akun Admin Organisasi
        </h2>

        <div class="grid md:grid-cols-2 gap-6">

            <div>

                <label class="block mb-2 font-bold text-sm text-slate-700">
                    Nama Admin
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 bg-slate-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 outline-none">

            </div>

            <div>

                <label class="block mb-2 font-bold text-sm text-slate-700">
                    Email Admin
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 bg-slate-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 outline-none">

            </div>

            <div>

                <label class="block mb-2 font-bold text-sm text-slate-700">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 bg-slate-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 outline-none">

            </div>

            <div>

                <label class="block mb-2 font-bold text-sm text-slate-700">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 bg-slate-50 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 outline-none">

            </div>

        </div>

        <button
            type="submit"
            class="mt-10 w-full py-4 bg-indigo-600 hover:bg-indigo-700 transition text-white rounded-2xl font-black text-lg shadow-lg shadow-indigo-200">

            Daftarkan Organisasi

        </button>

    </form>

    <div class="text-center mt-8">

        <a href="{{ route('admin.login') }}"
           class="text-indigo-600 font-semibold hover:underline">

            Sudah punya akun admin? Login

        </a>

    </div>

</div>

</body>
</html>