<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query dengan mengambil relasi kategorinya
        $query = Facility::with('category');

        // Jika ada parameter ?category=slug-kategori di URL, filter datanya
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $facilities = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar fasilitas berhasil dimuat',
            'data' => $facilities
        ]);
    }
}