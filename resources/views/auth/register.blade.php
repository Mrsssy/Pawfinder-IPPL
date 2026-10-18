<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - PawFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-800 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-4xl grid grid-cols-1 md:grid-cols-2">
        <!-- FORM KIRI -->
        <div class="p-8 md:p-12 flex flex-col justify-center">
            <a href="/" class="flex items-center gap-2 text-emerald-700 font-extrabold text-xl mb-6">
                <i class="fa-solid fa-paw text-2xl"></i> PawFinder
            </a>

            <h2 class="text-2xl font-bold text-gray-800 mb-1">Buat Akun Baru</h2>
            <p class="text-xs text-gray-400 mb-6">Daftar untuk mengakses peta interaktif & pelacakan lokasi</p>

            @if($errors->any())
                <div class="bg-red-50 text-red-600 text-xs p-3 rounded-lg mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="/register" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-semibold text-gray-600 block mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Nama Anda" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 block mb-1">Email</label>
                    <input type="email" name="email" required placeholder="nama@email.com" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 block mb-1">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 block mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-emerald-500">
                </div>

                <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-semibold py-3 rounded-xl text-sm transition shadow-md mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-xs text-center text-gray-500 mt-6">
                Sudah punya akun? <a href="/login" class="text-emerald-600 font-semibold hover:underline">Masuk di sini</a>
            </p>
        </div>

        <!-- ILUSTRASI KANAN -->
        <div class="bg-[#8b9b87] p-8 md:p-12 flex flex-col justify-between text-white relative hidden md:flex">
            <div>
                <i class="fa-solid fa-quote-left text-3xl opacity-30 mb-4 block"></i>
                <h3 class="text-2xl font-bold mb-2">Bergabung dengan Komunitas PawFinder</h3>
                <p class="text-xs text-emerald-100 leading-relaxed opacity-80">
                    Nikmati kemudahan menemukan fasilitas hewan terdekat dengan fitur Geolocation yang presisi.
                </p>
            </div>
            <div class="mt-8 flex justify-center">
                <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=600&auto=format&fit=crop" alt="Dog Illustration" class="rounded-2xl shadow-lg h-60 object-cover">
            </div>
        </div>
    </div>

</body>
</html>