<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Toko Daging Kokoh') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased relative">
        <!-- Background Image -->
        <div class="fixed inset-0 z-0" style="background: linear-gradient(135deg, rgba(254, 226, 226, 0.5) 0%, rgba(253, 230, 138, 0.5) 100%), url('/forbackground.jpg'); background-size: cover; background-position: center; background-attachment: fixed;"></div>
        
        <div class="min-h-screen flex flex-col md:flex-row items-center justify-center p-4 relative z-10">
            <!-- Left side - Branding -->
            <div class="md:w-1/2 md:pr-12 mb-8 md:mb-0">
                <div class="text-center md:text-left">
                    <div class="flex justify-center md:justify-start mb-6">
                        <img src="/mascotlogo.jpg" alt="Toko Daging Kokoh" class="w-32 h-32 object-contain">
                    </div>
                    <h1 class="text-4xl font-bold text-red-800 mb-4">Toko Daging Kokoh</h1>
                    <p class="text-gray-700 text-lg max-w-md mx-auto md:mx-0">
                        Kelola stok daging Anda dengan mudah dan efisien. Pantau produk, pemasok, pergerakan stok, dan buat laporan secara akurat.
                    </p>
                </div>
            </div>

            <!-- Right side - Form -->
            <div class="w-full md:w-1/2 max-w-md">
                <div class="bg-white bg-opacity-90 shadow-xl rounded-2xl overflow-hidden p-8 backdrop-blur-sm">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $title ?? 'Selamat Datang' }}</h2>
                        <p class="text-gray-600 mt-2">{{ $subtitle ?? 'Silakan masuk ke akun Anda' }}</p>
                    </div>
                    {{ $slot }}
                </div>
                
                <div class="mt-6 text-center text-gray-600 text-sm">
                    © {{ date('Y') }} Toko Daging Kokoh. Hak Cipta dilindungi.
                </div>
            </div>
        </div>
    </body>
</html>
