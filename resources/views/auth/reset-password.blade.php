<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <script>
        tailwind.config = {
            theme:{
                extend:{
                    fontFamily:{
                        sans:['Inter','sans-serif']
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
                Reset Password
            </h1>

            <p class="text-gray-500 mb-8">
                Masukkan email dan password baru Anda.
            </p>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">

                @csrf

                <!-- Token -->
                <input type="hidden"
                       name="token"
                       value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>

                    <label class="block text-sm text-gray-700 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $request->email) }}"
                        required
                        autofocus

                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

                </div>

                <!-- Password -->
                <div class="relative">

                    <label class="block text-sm text-gray-700 mb-2">
                        Password Baru
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required

                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <button
                        type="button"
                        onclick="togglePassword('password','eye1')"

                        class="absolute right-4 top-[46px] text-gray-500">

                        <i id="eye1" class="fas fa-eye"></i>

                    </button>

                </div>

                <!-- Confirm Password -->

                <div class="relative">

                    <label class="block text-sm text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required

                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <button
                        type="button"
                        onclick="togglePassword('password_confirmation','eye2')"

                        class="absolute right-4 top-[46px] text-gray-500">

                        <i id="eye2" class="fas fa-eye"></i>

                    </button>

                </div>

                <button
                    type="submit"

                    class="w-full py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition">

                    Reset Password

                </button>

            </form>

            <p class="text-center mt-8 text-gray-600">

                Kembali ke

                <a href="{{ route('login') }}"
                   class="text-blue-600 font-semibold hover:underline">

                    Login

                </a>

            </p>

        </div>

    </div>

    <!-- RIGHT -->

    <div class="hidden md:block w-1/2">

        <img src="{{ asset('img/ok.jpg') }}"
             class="w-full h-screen object-cover"
             alt="Reset Password">

    </div>

</div>

<script>

function togglePassword(inputId,iconId){

    const input=document.getElementById(inputId);
    const icon=document.getElementById(iconId);

    if(input.type==="password"){

        input.type="text";
        icon.classList.replace("fa-eye","fa-eye-slash");

    }else{

        input.type="password";
        icon.classList.replace("fa-eye-slash","fa-eye");

    }

}

</script>

</body>
</html>