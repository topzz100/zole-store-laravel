<?php

use Illuminate\Support\Facades\Route;
//routes web
Route::get('/', function () {
    return view('welcome');
});
