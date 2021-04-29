<?php

use App\Http\Controllers\Check\CheckController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Registration\RegistrationController;

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
    return view('index');
});

Route::get('/reg', function () {
    return view('reg');
});

Route::post('/reg/request', [RegistrationController::class, "request"]);
Route::post('/reg/execute', [RegistrationController::class, "execute"]);

Route::post('/api/check/personal',   [CheckController::class,  "personal"]);
Route::post('/api/check/company',   [CheckController::class,  "company"]);
