<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AlumnoController;
Route::resource('alumnos', AlumnoController::class);
