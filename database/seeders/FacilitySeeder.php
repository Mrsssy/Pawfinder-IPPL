<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('facilities')->truncate();
        DB::table('facility_categories')->truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Kategori Fasilitas
        $catKlinik = DB::table('facility_categories')->insertGetId([
            'name' => 'Klinik/Dokter Hewan',
            'slug' => 'klinik-hewan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $catPetshop = DB::table('facility_categories')->insertGetId([
            'name' => 'Petshop',
            'slug' => 'pet-shop',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $catGrooming = DB::table('facility_categories')->insertGetId([
            'name' => 'Grooming',
            'slug' => 'grooming',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Data Komprehensif Fasilitas Riil di Kota Balikpapan
        DB::table('facilities')->insert([
            // --- KLINIK & DOKTER HEWAN ---
            [
                'name' => 'Klinik Hewan Cetar Pet\'s (Drh. Tri Retno Wati)',
                'category_id' => $catKlinik,
                'address' => 'Jl. Inpres I No.10, Muara Rapak, Kec. Balikpapan Utara',
                'phone' => '0812-1767-5407',
                'description' => 'Layanan jasa konsultasi, pengobatan, operasi, vaksinasi, opname, USG, hingga scaling gigi.',
                'latitude' => -1.237500,
                'longitude' => 116.842100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Totok Vet Service',
                'category_id' => $catKlinik,
                'address' => 'Jl. Jalan Satu No.50, Gunung Samarinda, Kec. Balikpapan Utara',
                'phone' => '0812-5561-1917',
                'description' => 'Klinik dan layanan medis profesional untuk hewan kesayangan dengan dokter berpengalaman.',
                'latitude' => -1.231200,
                'longitude' => 116.853400,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jose Vet Clinic',
                'category_id' => $catKlinik,
                'address' => 'Jl. Sumber Rejo, Kec. Balikpapan Tengah',
                'phone' => '0542-000000',
                'description' => 'Klinik hewan terpercaya dengan fasilitas lengkap, bersih, serta penanganan medis profesional.',
                'latitude' => -1.248900,
                'longitude' => 116.838500,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // --- PETSHOP & GROOMING ---
            [
                'name' => 'Winning Petshop, Grooming & Pet Hotel',
                'category_id' => $catGrooming,
                'address' => 'Jl. Syarifuddin Yoes No.34, Gn. Bahagia, Kec. Balikpapan Selatan',
                'phone' => '0821-4883-2120',
                'description' => 'Pusat perawatan grooming profesional, pet shop lengkap, dan layanan pet hotel.',
                'latitude' => -1.251200,
                'longitude' => 116.879500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pesona Pet Shop & Care',
                'category_id' => $catPetshop,
                'address' => 'Jl. DI Panjaitan (Gunung Samarinda), Kec. Balikpapan Utara',
                'phone' => '0542-875123',
                'description' => 'Menyediakan produk perlengkapan hewan super lengkap, variatif, dan harga kompetitif.',
                'latitude' => -1.243500,
                'longitude' => 116.857200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Olix Petshop & Grooming',
                'category_id' => $catPetshop,
                'address' => 'Jl. Ahmad Yani No.51, Gunungsari Ulu, Kec. Balikpapan Tengah',
                'phone' => '0813-5566-7889',
                'description' => 'Pusat kebutuhan anabul terkemuka di pusat kota yang juga menyediakan layanan grooming.',
                'latitude' => -1.264200,
                'longitude' => 116.833500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'B Petshop & Grooming',
                'category_id' => $catPetshop,
                'address' => 'Jl. MT. Haryono No.78, Batu Ampar, Kec. Balikpapan Utara',
                'phone' => '0812-3344-5566',
                'description' => 'Menyediakan makanan premium (Royal Canin, dll), aksesoris, mainan, hingga obat & vitamin.',
                'latitude' => -1.223400,
                'longitude' => 116.854100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Home Pet Shop & Hotel',
                'category_id' => $catGrooming,
                'address' => 'Gn. Bahagia, Kec. Balikpapan Selatan',
                'phone' => '0542-111222',
                'description' => 'Toko perlengkapan hewan, jasa grooming profesional, serta penitipan hewan peliharaan.',
                'latitude' => -1.252000,
                'longitude' => 116.872000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dianmalia Petshop & Vet',
                'category_id' => $catPetshop,
                'address' => 'Jl. Syarifuddin Yoes No.25, Sepinggan, Kec. Balikpapan Selatan',
                'phone' => '0812-9988-7766',
                'description' => 'Pilihan favorit warga Balikpapan untuk berbelanja kebutuhan pakan dan perawatan hewan.',
                'latitude' => -1.248000,
                'longitude' => 116.882000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Talita Pet Shop',
                'category_id' => $catPetshop,
                'address' => 'Jl. Dr. Soetomo No.23, Karang Rejo, Kec. Balikpapan Tengah',
                'phone' => '0813-1122-3344',
                'description' => 'Menyediakan berbagai macam kebutuhan harian kucing dan anjing peliharaan.',
                'latitude' => -1.241000,
                'longitude' => 116.845000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}