<?php

use App\Http\Controllers\CadastroContratoController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\FornecedoresController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/contracts', [CadastroContratoController::class, 'getAll']);
Route::put('/contracts', [CadastroContratoController::class, 'filter']);
Route::post('/contracts', [CadastroContratoController::class, 'store']);

Route::get('/departments', [DepartamentosController::class, 'getAll']);
Route::post('/departments', [DepartamentosController::class, 'store']);

Route::get('/suppliers', [FornecedoresController::class, 'getAll']);
Route::post('/suppliers', [FornecedoresController::class, 'store']);
