<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityCategory extends Model
{
    use HasFactory;

    protected $table = 'facility_categories';
    
    // Jika di database aslinya kolom nama itu bukan 'name', melainkan nama lain, 
    // tapi kalau di migrasi aslinya 'name', mari kita pastikan dilindungi:
    protected $guarded = [];
}