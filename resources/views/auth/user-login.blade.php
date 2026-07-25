<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AmikomEventHub</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Plus Jakarta Sans',sans-serif;
        }
    </style>
</head>

<body class="bg-indigo-900 min-h-screen flex justify-center items-center">

<div class="bg-white rounded-3xl shadow-xl p-10 w-full max-w-md">

    <h1 class="text-3xl font-bold text-center">
        Login
    </h1>

    <p class="text-center text-gray-500 mt-2">
        Login untuk melanjutkan pemesanan tiket
    </p>

    <a href="{{ route('google.login') }}"
       class="mt-8 flex justify-center items-center gap-3 bg-red-500 hover:bg-red-600 text-white py-4 rounded-xl font-semibold">

        Continue with Google

    </a>

</div>

</body>
</html>