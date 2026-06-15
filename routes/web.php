<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/souCandidato', function () {
    return view('souCandidato');
})->name('souCandidato');

Route::get('/souRecrutador', function () {
    return view('souRecrutador');
})->name('souRecrutador');
