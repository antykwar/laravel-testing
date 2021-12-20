<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    Mail::raw('This is my prod message', function($message) {
        $message->from('one@prod.mail');
        $message->to('another@prod.mail');
    });
})->name('home-page');

Route::get('/clicked', function () {
    return view('clicked');
})->name('clicked-page');
