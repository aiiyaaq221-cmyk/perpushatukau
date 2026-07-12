<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen font-sans">

<div class="flex min-h-screen">

    <!-- LEFT -->
    <div class="w-full md:w-1/2 flex items-center justify-center bg-white p-10">

        <div class="w-full max-w-md">

            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                Forgot Password
            </h1>

            <p class="text-gray-500 mb-8">
                Masukkan alamat email Anda. Kami akan mengirimkan tautan untuk mengatur ulang password.
            </p>

            {{-- Status --}}
            @if (session('status'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">

                @csrf

                <div>

                    <label class="block text-sm text-gray-700 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan Email"
                        required
                        autofocus

                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <button
                    type="submit"

                    class="w-full py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition">

                    Kirim Link Reset Password

                </button>

            </form>

            <div class="flex justify-between mt-8 text-sm">

                <a href="{{ route('login') }}"
                   class="text-blue-600 hover:underline">

                    Login

                </a>

                <!-- <a href="{{ route('register') }}"
                   class="text-blue-600 hover:underline">

                    Register

                </a> -->

            </div>

        </div>

    </div>

    <!-- RIGHT -->

    <div class="hidden md:block w-1/2">

        <img
            src="{{ asset('img/gedung.jpeg') }}"
            alt="Forgot Password"
            class="w-full h-screen object-cover">

    </div>
</div>
</body>
</html>