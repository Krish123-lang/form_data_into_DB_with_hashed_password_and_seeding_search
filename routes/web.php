<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

// Route::get('/', function () {
//     return view('form');
// });

Route::resource('/', RegistrationController::class);
