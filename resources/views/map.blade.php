<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawFinder - Lokasi & Peta Fasilitas Balikpapan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #map { height: 100vh; width: 100%; }
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col md:flex-row h-screen overflow-hidden">

    <!-- PANEL KIRI: DAFTAR FASILITAS & PENCARIAN -->
    <div class="w-full md:w-5/12 lg:w-4/12 bg-white flex flex-col h-full shadow-lg z-10">
        
        <!-- Header Panel (Dilengkapi Tombol Kembali Beranda & Akun User) -->
        <div class="p-5 border-b border-gray-100 bg-white">
            <div class="flex items-center justify-between mb-4">
                <!-- Tombol Kembali ke Beranda -->
                <a href="/" class="flex items-center gap-2 text-emerald-700 font-extrabold text-xl hover:opacity-80 transition" title="Kembali ke Beranda">
                    <i class="fa-solid fa-arrow-left text-sm text-gray-500"></i>
                    <i class="fa-solid fa-paw text-2xl text-emerald-600"></i> PawFinder
                </a>
                
                <!-- Status User & Logout -->
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-700 bg-gray-100 px-3 py-1 rounded-full">
                        👤 {{ Auth::user()->name }}
                    </span>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 p-1.5 rounded-full hover:bg-red-50 transition" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Input Cari & Geolocation -->
            <div class="relative mb-3">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-3.5 text-gray-400"></i>
                <input type="text" id="searchInput" onkeyup="filterFacilities()" placeholder="Cari fasilitas di Balikpapan..." 
                       class="w-full pl-10 pr-10 py-2.5 bg-gray-100 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <button onclick="getUserLocation()" title="Gunakan Lokasi Saya" class="absolute right-3 top-2.5 text-emerald-600 hover:text-emerald-700 bg-emerald-50 p-1.5 rounded-full">
                    <i class="fa-solid fa-location-crosshairs"></i>
                </button>
            </div>

            <!-- Filter Kategori Kapsul -->
            <div class="flex gap-2 overflow-x-auto pb-1 text-xs font-medium custom-scroll">
                <button onclick="setCategory('')" class="cat-btn bg-emerald-700 text-white px-3 py-1.5 rounded-full whitespace-nowrap active-cat" data-cat="">Semua</button>
                <button onclick="setCategory('klinik-hewan')" class="cat-btn bg-gray-100 text-gray-600 hover:bg-emerald-50 px-3 py-1.5 rounded-full whitespace-nowrap" data-cat="klinik-hewan">🏥 Klinik Hewan</button>
                <button onclick="setCategory('pet-shop')" class="cat-btn bg-gray-100 text-gray-600 hover:bg-emerald-50 px-3 py-1.5 rounded-full whitespace-nowrap" data-cat="pet-shop">🛍️ Petshop</button>
                <button onclick="setCategory('grooming')" class="cat-btn bg-gray-100 text-gray-600 hover:bg-emerald-50 px-3 py-1.5 rounded-full whitespace-nowrap" data-cat="grooming">✂️ Grooming</button>
            </div>
        </div>

        <!-- List Item Fasilitas -->
        <div id="facilityList" class="flex-1 overflow-y-auto p-4 space-y-4 custom-scroll">
            <div class="text-center py-8 text-gray-400 text-sm">Memuat data fasilitas...</div>
        </div>
    </div>

    <!-- PANEL KANAN: MAPS -->
    <div class="w-full md:w-7/12 lg:w-8/12 h-full relative">
        <div id="map"></div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi Peta (Pusat Kota Balikpapan)
        const balikpapanCoords = [-1.265380, 116.831200];
        const map = L.map('map').setView(balikpapanCoords, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let markersLayer = L.layerGroup().addTo(map);
        let userMarker = null;
        let allFacilities = [];
        let currentCategory = '';

        // Ambil Data Fasilitas dari Backend API
        function fetchFacilities() {
            fetch('/api/facilities')
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        allFacilities = res.data;
                        renderFacilities();
                    }
                })
                .catch(err => console.error('Gagal mengambil data:', err));
        }

        function setCategory(cat) {
            currentCategory = cat;
            document.querySelectorAll('.cat-btn').forEach(btn => {
                if (btn.getAttribute('data-cat') === cat) {
                    btn.className = 'cat-btn bg-emerald-700 text-white px-3 py-1.5 rounded-full whitespace-nowrap';
                } else {
                    btn.className = 'cat-btn bg-gray-100 text-gray-600 hover:bg-emerald-50 px-3 py-1.5 rounded-full whitespace-nowrap';
                }
            });
            renderFacilities();
        }

        function filterFacilities() {
            renderFacilities();
        }

        function renderFacilities() {
            const keyword = document.getElementById('searchInput').value.toLowerCase();
            markersLayer.clearLayers();
            const listContainer = document.getElementById('facilityList');
            listContainer.innerHTML = '';

            const filtered = allFacilities.filter(item => {
                const matchCat = currentCategory === '' || (item.category && item.category.slug === currentCategory);
                const matchSearch = item.name.toLowerCase().includes(keyword) || item.address.toLowerCase().includes(keyword);
                return matchCat && matchSearch;
            });

            if (filtered.length === 0) {
                listContainer.innerHTML = `<div class="text-center py-8 text-gray-400 text-sm">Tidak ada fasilitas ditemukan.</div>`;
                return;
            }

            filtered.forEach(item => {
                // Pasang Marker di Map
                if (item.latitude && item.longitude) {
                    const marker = L.marker([item.latitude, item.longitude]).addTo(markersLayer);
                    marker.bindPopup(`
                        <div class="p-1">
                            <b class="text-emerald-700 font-bold">${item.name}</b><br>
                            <span class="text-xs text-gray-600">${item.address}</span><br>
                            <a href="tel:${item.phone}" class="text-xs text-blue-600 font-semibold mt-1 inline-block">📞 ${item.phone}</a>
                        </div>
                    `);
                }

                // Buat Kartu di Panel Kiri
                const card = document.createElement('div');
                card.className = 'bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition cursor-pointer';
                card.onclick = () => {
                    map.flyTo([item.latitude, item.longitude], 16);
                };
                card.innerHTML = `
                    <div class="flex justify-between items-start">
                        <h3 class="font-bold text-gray-800 text-sm">${item.name}</h3>
                        <span class="bg-emerald-50 text-emerald-700 text-[10px] font-semibold px-2 py-0.5 rounded-full">${item.category ? item.category.name : 'Fasilitas'}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 line-clamp-2"><i class="fa-solid fa-location-dot text-emerald-500 mr-1"></i>${item.address}</p>
                    <div class="mt-3 flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-gray-50">
                        <span>📞 ${item.phone || '-'}</span>
                        <span class="text-emerald-600 font-semibold hover:underline">Lihat di Peta &rarr;</span>
                    </div>
                `;
                listContainer.appendChild(card);
            });
        }

        // Fitur Geolocation Pelacakan Lokasi Pengguna
        function getUserLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    if (userMarker) map.removeLayer(userMarker);

                    userMarker = L.circleMarker([lat, lng], {
                        radius: 9,
                        fillColor: "#2563eb",
                        color: "#ffffff",
                        weight: 3,
                        opacity: 1,
                        fillOpacity: 0.9
                    }).addTo(map).bindPopup("<b>📍 Lokasi Anda Saat Ini</b>").openPopup();

                    map.flyTo([lat, lng], 14);
                }, () => {
                    alert('Gagal mengambil lokasi. Pastikan izin lokasi (GPS) diaktifkan di browser Anda.');
                });
            } else {
                alert('Browser Anda tidak mendukung fitur Geolocation.');
            }
        }

        // Jalankan saat halaman terbuka
        fetchFacilities();
    </script>
</body>
</html>