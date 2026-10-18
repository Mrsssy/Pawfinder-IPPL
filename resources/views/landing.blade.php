<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawFinder - Temukan Fasilitas Hewan di Balikpapan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8faf8] font-sans text-gray-800">

    <!-- NAVBAR -->
    <nav class="flex items-center justify-between px-8 py-5 bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-emerald-50">
        <a href="/" class="flex items-center gap-2 text-emerald-700 font-extrabold text-2xl tracking-tight">
            <i class="fa-solid fa-paw text-2xl text-emerald-600"></i> PawFinder
        </a>
        <div class="hidden md:flex items-center gap-8 font-medium text-sm text-gray-600">
            <a href="/" class="text-emerald-700 font-bold border-b-2 border-emerald-600 pb-1">Beranda</a>
            <a href="/map" class="hover:text-emerald-600 transition">Peta Fasilitas</a>
            <a href="/chat" class="hover:text-emerald-600 transition">AI Paw Assistant</a>
        </div>
        <div class="flex items-center gap-3">
            @auth
                <span class="text-sm font-semibold text-gray-700 mr-2">Halo, {{ Auth::user()->name }}</span>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-red-500 hover:text-red-600 border border-red-200 px-4 py-2 rounded-full transition">
                        Keluar <i class="fa-solid fa-right-from-bracket ml-1"></i>
                    </button>
                </form>
            @else
                <a href="/login" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800 px-4 py-2 rounded-full transition">Masuk</a>
                <a href="/login" class="text-sm font-semibold bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-2 rounded-full shadow-md transition">Daftar</a>
            @endauth
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="max-w-7xl mx-auto px-6 py-12 md:py-20 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <div>
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight mb-4">
                Cari Petshop, Klinik, atau Grooming di Sekitarmu
            </h1>
            <p class="text-gray-600 text-base mb-8 leading-relaxed">
                PawFinder membantu kamu menemukan fasilitas terbaik untuk hewan peliharaan di Balikpapan dengan mudah melalui peta interaktif. Dapatkan juga rekomendasi perawatan dari AI Paw Assistant kami.
            </p>

            <!-- BAR PENCARIAN CEPAT -->
            <div class="bg-white p-3 rounded-full shadow-lg border border-gray-100 flex flex-col md:flex-row items-center gap-2 mb-6">
                <div class="flex items-center gap-2 px-4 w-full md:w-auto flex-1">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    <input type="text" placeholder="Cari nama fasilitas..." class="w-full text-sm outline-none bg-transparent">
                </div>
                <a href="/map" class="w-full md:w-auto bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-sm px-6 py-3 rounded-full text-center transition flex items-center justify-center gap-2 shadow-md">
                    <i class="fa-solid fa-map-location-dot"></i> Lihat Peta
                </a>
            </div>

            <!-- CHIPS KATEGORI -->
            <div class="flex items-center gap-3">
                <a href="/map?cat=pet-shop" class="bg-red-50 text-red-600 border border-red-100 px-4 py-1.5 rounded-full text-xs font-semibold hover:bg-red-100 transition flex items-center gap-2">
                    🛍️ Petshop
                </a>
                <a href="/map?cat=klinik-hewan" class="bg-blue-50 text-blue-600 border border-blue-100 px-4 py-1.5 rounded-full text-xs font-semibold hover:bg-blue-100 transition flex items-center gap-2">
                    🏥 Klinik/Dokter Hewan
                </a>
                <a href="/map?cat=grooming" class="bg-purple-50 text-purple-600 border border-purple-100 px-4 py-1.5 rounded-full text-xs font-semibold hover:bg-purple-100 transition flex items-center gap-2">
                    ✂️ Grooming
                </a>
            </div>
        </div>

        <!-- HERO BANNER / MAP PREVIEW -->
        <div class="relative">
            <div class="bg-emerald-100/60 rounded-3xl p-6 relative overflow-hidden flex justify-center items-center">
                <img src="https://images.unsplash.com/photo-1548767797-d8c844163c4c?q=80&w=800&auto=format&fit=crop" 
                     alt="PawFinder Banner" 
                     class="rounded-2xl object-cover h-[350px] w-full shadow-md">
            </div>
        </div>
    </section>

    <!-- KARTU FITUR UTAMA -->
    <section class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 md:grid-cols-4 gap-6">
        <a href="/map" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl mb-4">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-lg mb-1">Peta Interaktif</h3>
            <p class="text-xs text-gray-500 leading-relaxed">Temukan petshop, klinik, dan grooming terdekat dengan lokasi GPS secara akurat.</p>
        </a>

        <a href="/chat" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl mb-4">
                <i class="fa-solid fa-robot"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-lg mb-1">AI Paw Assistant</h3>
            <p class="text-xs text-gray-500 leading-relaxed">Konsultasi perawatan dan gejala kesehatan hewan peliharaan berbasis AI cerdas.</p>
        </a>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl mb-4">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-lg mb-1">Info Terpercaya</h3>
            <p class="text-xs text-gray-500 leading-relaxed">Data fasilitas Balikpapan terverifikasi lengkap dengan nomor telepon & lokasi.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl mb-4">
                <i class="fa-solid fa-heart"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-lg mb-1">Untuk Anabul Kesayangan</h3>
            <p class="text-xs text-gray-500 leading-relaxed">Dirancang penuh kasih sayang untuk membantu pemeliharaan hewan peliharaanmu.</p>
        </div>
    </section>

</body>
</html>