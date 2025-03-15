<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/{any}', function () {
//    $path = public_path('vue/index.html');
//
//    if (!File::exists($path)) {
//        abort(404);
//    }
//
//    return Responder::file($path);
//})->where('any', '.*');
