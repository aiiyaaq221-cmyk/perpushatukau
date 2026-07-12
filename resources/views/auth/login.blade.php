<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="min-h-screen font-sans">

<div class="flex min-h-screen">

    <!-- ================= LEFT ================= -->
    <div class="w-full md:w-1/2 flex justify-center items-center bg-white px-8">

        <div class="w-full max-w-md">

            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                LOGIN
            </h1>

            <p class="text-gray-500 mb-8">
                Selamat Datang, silahkan login untuk melanjutkan.
            </p>

            {{-- Error --}}
            @if($errors->has('login'))
            <div class="mb-5 rounded-lg bg-red-100 border border-red-200 p-4 text-red-600 text-sm">
                <ul class="list-disc ml-5">
                    <li>{{ $errors->first('login') }}</li>
                </ul>
            </div>
            @endif

            {{-- Success --}}
            @if(session('status'))
                <div class="mb-5 rounded-lg bg-green-100 border border-green-200 p-4 text-green-600 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- notip -->
            @if(session('login_success') || session('logout_success'))
                <div id="auth-notification"
                    class="fixed bottom-5 left-1/2 transform -translate-x-1/2
                            px-4 py-2 rounded-lg shadow-md text-sm z-50 transition-opacity duration-500
                            {{ session('login_success')
                                ? 'bg-green-100 border border-green-300 text-green-700'
                                : 'bg-blue-100 border border-blue-300 text-blue-700' }}">

                    {{ session('login_success') ?? session('logout_success') }}

                </div>

                <script>
                setTimeout(() => {
                    const notif = document.getElementById('auth-notification');

                    if(notif){
                        notif.style.opacity = '0';

                        setTimeout(() => {
                            notif.remove();
                        }, 500);
                    }
                }, 3000);
                </script>

                @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>

                @csrf

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm text-gray-700 mb-2">
                        Email
                    </label>

                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email"  required autofocus
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                </div>

                <!-- PASSWORD -->
                <div class="relative">

                    <label class="block text-sm text-gray-700 mb-2">
                        Password
                    </label>

                    <input type="password" name="password" id="password" placeholder="Masukkan Password" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('password')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    <button
                        type="button"
                        onclick="togglePassword()"
                        class="absolute right-4 top-[46px] text-gray-500">

                        <i id="eyeIcon" class="fas fa-eye"></i>

                    </button>

                </div>

                <!-- Forgot -->
                <div class="text-right">

                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-blue-600 hover:underline">
                            Forgot Password?
                        </a>
                    @endif

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"

                    class="w-full rounded-lg bg-yellow-500 py-3 font-semibold text-white hover:bg-yellow-600 transition">

                    Login

                </button>

            </form>

            <!-- <p class="text-center mt-8 text-gray-600">

                Belum punya akun?

                @if(Route::has('register'))

                    <a href="{{ route('register') }}"
                        class="text-blue-600 font-semibold hover:underline">
                        Register
                    </a>
                @endif
            </p> -->

        </div>

    </div>

    <!-- ================= RIGHT ================= -->

    <div class="hidden md:block md:w-1/2">

        <img
            src="{{ asset('img/gedung.jpeg') }}"
            class="w-full h-screen object-cover"
            alt="Login Image">

    </div>

</div>

<script>

function togglePassword(){

    let password=document.getElementById('password');
    let eye=document.getElementById('eyeIcon');

    if(password.type==="password"){

        password.type="text";
        eye.classList.replace("fa-eye","fa-eye-slash");

    }else{

        password.type="password";
        eye.classList.replace("fa-eye-slash","fa-eye");

    }

}

</script>

</body>
</html>