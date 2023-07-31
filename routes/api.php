<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CidadesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'api'], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::get('user', [AuthController::class, 'index']);

    Route::post('medicos', [MedicoController::class, 'create']);
    Route::get('medicos', [MedicoController::class, 'index']);
    Route::get('/cidades/{id_cidade}/medicos', [MedicoController::class, 'show']);
});

Route::controller(CidadesController::class)->group(function () {
    Route::post('/cidades', 'create');
    Route::get('/cidades', 'index');
});
