<?php

use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
