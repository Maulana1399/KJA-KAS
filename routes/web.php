<?php

use Illuminate\Support\Facades\Route;

// Route::redirect('/', '/kas'); 
Route::get('/', function () {
    return view('welcome');
});
