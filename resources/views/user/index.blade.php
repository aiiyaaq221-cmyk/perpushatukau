<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard user</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-image: url('{{ asset('img/ok.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-900 text-white">
        <h1 class="text-2xl font-bold text-white mb-6">Dashboard user</h1>
        <p class="text-gray-300 mb-4">Selamat datang di dashboard user</p>
        <br>
        
        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button class="btn logout-btn">

                <i class="fas fa-sign-out-alt"></i>

                <span>Logout</span>

            </button>

        </form>
<br/>
</body>
</html>
