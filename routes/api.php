<?php

use App\Http\Controllers\Api\FacilityController;
use Illuminate\Support\Facades\Route;

Route::get('/facilities', [FacilityController::class, 'index']);