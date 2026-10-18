<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Paw Assistant - PawFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
    </style>
</head>
<body class="bg-[#f4f7f4] font-sans text-gray-800 flex h-screen overflow-hidden">

    <!-- SIDEBAR NAVIGASI KIRI -->
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col justify-between hidden md:flex">
        <div class="p-6">
            <a href="/" class="flex items-center gap-2 text-emerald-700 font-extrabold text-2xl mb-8">
                <i class="fa-solid fa-paw text-2xl text-emerald-600"></i> PawFinder
            </a>

            <nav class="space-y-1">
                <a href="/" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-gray-600 rounded-xl hover:bg-gray-50 transition">
                    <i class="fa-solid fa-house w-5 text-gray-400"></i> Beranda
                </a>
                <a href="/map" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-gray-600 rounded-xl hover:bg-gray-50 transition">
                    <i class="fa-solid fa-map-location-dot w-5 text-gray-400"></i> Peta Fasilitas
                </a>
                <a href="/chat" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-emerald-700 bg-emerald-50 rounded-xl transition">
                    <i class="fa-solid fa-robot w-5 text-emerald-600"></i> AI Paw Assistant
                </a>
            </nav>
        </div>

        <!-- PROFILE / LOGOUT -->
        <div class="p-4 border-t border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="text-xs">
                    <p class="font-bold text-gray-800 truncate max-w-[100px]">{{ Auth::user()->name }}</p>
                    <p class="text-gray-400">Pengguna</p>
                </div>
            </div>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-500 p-2 text-sm transition" title="Keluar">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- AREA UTAMA CHAT -->
    <main class="flex-1 flex flex-col h-full bg-white md:bg-[#f4f7f4] p-0 md:p-6">
        <div class="flex-1 bg-white md:rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row overflow-hidden">
            
            <!-- PANEL CHAT -->
            <div class="flex-1 flex flex-col h-full border-r border-gray-100">
                <!-- Header Chat -->
                <div class="p-4 md:p-5 border-b border-gray-100 flex items-center justify-between bg-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-lg">
                            <i class="fa-solid fa-robot"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-800 text-base">AI Paw Assistant</h2>
                            <p class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Tersedia 24/7
                            </p>
                        </div>
                    </div>
                    <a href="/" class="md:hidden text-gray-500 text-sm"><i class="fa-solid fa-house"></i></a>
                </div>

                <!-- Bubble Chat Stream -->
                <div id="chatStream" class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4 custom-scroll bg-gray-50/50">
                    <!-- Pesan Awal AI -->
                    <div class="flex gap-3 items-start">
                        <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-xs shrink-0 mt-1">
                            <i class="fa-solid fa-robot"></i>
                        </div>
                        <div class="bg-white p-4 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm max-w-[85%] text-sm text-gray-700 leading-relaxed">
                            Halo! Aku <b>Paw Assistant</b> 🐾<br>
                            Aku siap membantu kamu dengan berbagai pertanyaan seputar kesehatan hewan peliharaan, perawatan, gejala, dan rekomendasi fasilitas terdekat di Balikpapan. Apa yang bisa aku bantu hari ini?
                        </div>
                    </div>
                </div>

                <!-- Form Input Pesan -->
                <div class="p-4 bg-white border-t border-gray-100">
                    <form id="chatForm" onsubmit="sendChatMessage(event)" class="flex items-center gap-2">
                        <input type="text" id="chatInput" placeholder="Tulis pertanyaan seputar anabulmu..." required
                               class="flex-1 px-4 py-3 bg-gray-100 rounded-full text-sm outline-none focus:ring-2 focus:ring-emerald-500">
                        <button type="submit" class="w-11 h-11 bg-emerald-700 hover:bg-emerald-800 text-white rounded-full flex items-center justify-center transition shadow-md shrink-0">
                            <i class="fa-solid fa-paper-plane text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- PANEL REKOMENDASI / PERTANYAAN CEPAT (KANAN) -->
            <div class="w-80 p-6 bg-gray-50/60 hidden lg:block overflow-y-auto custom-scroll">
                <div class="bg-emerald-50/80 p-5 rounded-2xl mb-6 border border-emerald-100 text-center">
                    <div class="w-12 h-12 bg-white text-emerald-600 rounded-2xl flex items-center justify-center text-xl mx-auto mb-3 shadow-sm">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <h3 class="font-bold text-emerald-900 text-sm mb-1">Paw Assistant</h3>
                    <p class="text-xs text-emerald-700 leading-relaxed">Asisten AI khusus perawatan & panduan kesehatan hewan peliharaan.</p>
                </div>

                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Pertanyaan Cepat</h4>
                <div class="space-y-2">
                    <button onclick="quickPrompt('Kucing saya terlihat lesu dan tidak mau makan, apa yang harus dilakukan?')" 
                            class="w-full text-left p-3 bg-white rounded-xl text-xs font-medium text-gray-700 hover:border-emerald-300 border border-gray-100 shadow-sm transition flex items-center justify-between group">
                        <span>Gejala kucing lesu & lemas</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-300 group-hover:text-emerald-500"></i>
                    </button>
                    <button onclick="quickPrompt('Rekomendasikan klinik atau dokter hewan terdekat di Balikpapan')" 
                            class="w-full text-left p-3 bg-white rounded-xl text-xs font-medium text-gray-700 hover:border-emerald-300 border border-gray-100 shadow-sm transition flex items-center justify-between group">
                        <span>Rekomendasi klinik Balikpapan</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-300 group-hover:text-emerald-500"></i>
                    </button>
                    <button onclick="quickPrompt('Dimana tempat grooming kucing dan anjing terbaik?')" 
                            class="w-full text-left p-3 bg-white rounded-xl text-xs font-medium text-gray-700 hover:border-emerald-300 border border-gray-100 shadow-sm transition flex items-center justify-between group">
                        <span>Tempat grooming & salon pet</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-300 group-hover:text-emerald-500"></i>
                    </button>
                </div>
            </div>

        </div>
    </main>

    <script>
        function quickPrompt(text) {
            document.getElementById('chatInput').value = text;
            sendChatMessage(new Event('submit'));
        }

        function sendChatMessage(e) {
            e.preventDefault();
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            if (!message) return;

            const stream = document.getElementById('chatStream');

            // Tambah Bubble Chat User
            const userBubble = `
                <div class="flex gap-3 justify-end items-start">
                    <div class="bg-emerald-700 text-white p-4 rounded-2xl rounded-tr-none text-sm max-w-[85%] shadow-sm leading-relaxed">
                        ${message}
                    </div>
                </div>
            `;
            stream.insertAdjacentHTML('beforeend', userBubble);
            input.value = '';
            stream.scrollTop = stream.scrollHeight;

            // Efek Loading AI
            const loadingId = 'loading-' + Date.now();
            const loadingBubble = `
                <div id="${loadingId}" class="flex gap-3 items-start">
                    <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-xs shrink-0 mt-1">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <div class="bg-white p-4 rounded-2xl rounded-tl-none border border-gray-100 text-sm text-gray-400 shadow-sm">
                        <i class="fa-solid fa-circle-notch animate-spin mr-1"></i> Paw Assistant sedang mengetik...
                    </div>
                </div>
            `;
            stream.insertAdjacentHTML('beforeend', loadingBubble);
            stream.scrollTop = stream.scrollHeight;

            // Kirim AJAX ke Laravel Endpoint
            fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById(loadingId).remove();
                
                const aiReply = `
                    <div class="flex gap-3 items-start">
                        <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-xs shrink-0 mt-1">
                            <i class="fa-solid fa-robot"></i>
                        </div>
                        <div class="bg-white p-4 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm max-w-[85%] text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                            ${data.reply}
                        </div>
                    </div>
                `;
                stream.insertAdjacentHTML('beforeend', aiReply);
                stream.scrollTop = stream.scrollHeight;
            })
            .catch(() => {
                document.getElementById(loadingId).remove();
            });
        }
    </script>
</body>
</html>