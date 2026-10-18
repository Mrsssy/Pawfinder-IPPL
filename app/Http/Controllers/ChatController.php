<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = strtolower($request->message);

        // 1. Cek Kata Kunci Klinik / Dokter / Sakit / Medis
        if (str_contains($userMessage, 'klinik') || str_contains($userMessage, 'dokter') || str_contains($userMessage, 'vet') || str_contains($userMessage, 'sakit') || str_contains($userMessage, 'lesu')) {
            $facilities = Facility::whereHas('category', function($q) {
                $q->where('slug', 'klinik-hewan');
            })->get();

            $reply = "Berikut adalah daftar **Klinik & Dokter Hewan** di Balikpapan yang terdaftar di peta PawFinder:\n\n";
            foreach ($facilities as $f) {
                $reply .= "🏥 **{$f->name}**\n📍 Alamat: {$f->address}\n📞 Telp: {$f->phone}\n\n";
            }
            $reply .= "Kamu bisa melihat titik lokasi presisinya di menu **Peta Fasilitas**!";
            
            return response()->json(['success' => true, 'reply' => $reply]);
        }

        // 2. Cek Kata Kunci Petshop / Makanan / Pakan / Mawar
        if (str_contains($userMessage, 'petshop') || str_contains($userMessage, 'pet shop') || str_contains($userMessage, 'makanan') || str_contains($userMessage, 'pakan') || str_contains($userMessage, 'kandang')) {
            $facilities = Facility::whereHas('category', function($q) {
                $q->where('slug', 'pet-shop');
            })->get();

            $reply = "Berikut adalah daftar **Petshop** di Balikpapan yang terdaftar di peta PawFinder:\n\n";
            foreach ($facilities as $f) {
                $reply .= "🛍️ **{$f->name}**\n📍 Alamat: {$f->address}\n📞 Telp: {$f->phone}\n\n";
            }
            $reply .= "Silakan cek lokasi lengkapnya melalui menu **Peta Fasilitas**!";

            return response()->json(['success' => true, 'reply' => $reply]);
        }

        // 3. Cek Kata Kunci Grooming / Mandi / Salon / Bulu
        if (str_contains($userMessage, 'grooming') || str_contains($userMessage, 'mandi') || str_contains($userMessage, 'salon') || str_contains($userMessage, 'spa')) {
            $facilities = Facility::whereHas('category', function($q) {
                $q->where('slug', 'grooming');
            })->get();

            $reply = "Berikut adalah rekomendasi tempat **Grooming & Pet Spa** di Balikpapan yang ada di peta PawFinder:\n\n";
            foreach ($facilities as $f) {
                $reply .= "✂️ **{$f->name}**\n📍 Alamat: {$f->address}\n📞 Telp: {$f->phone}\n\n";
            }
            $reply .= "Buka menu **Peta Fasilitas** untuk petunjuk arah langsung ke lokasinya!";

            return response()->json(['success' => true, 'reply' => $reply]);
        }

        // Respon default jika kata kunci tidak cocok
        $reply = "Halo! Aku **AI Paw Assistant** 🐾.\n\nSilakan tanyakan info fasilitas di Balikpapan dengan mengetik kata kunci seperti:\n- **'klinik'** / **'dokter'** untuk mencari penanganan medis.\n- **'petshop'** untuk mencari tempat jual pakan/aksesoris.\n- **'grooming'** / **'mandi'** untuk perawatan anabul.";

        return response()->json(['success' => true, 'reply' => $reply]);
    }
}