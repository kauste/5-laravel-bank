<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaversClientController;

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
Route::get('/', [SaversClientController::class, 'index']);
Route::get('/list', [SaversClientController::class, 'index'])->name('list');
Route::get('/create',[SaversClientController::class, 'create'])->name('showCreate');
Route::post('/create',[SaversClientController::class, 'store'])->name('doCreate'); 
Route::get('/edit/{saversClient}/{addOrWithdrow?}', [SaversClientController::class, 'edit'])->name('clientEdit');
Route::put('/edit/{saversClient}/{addOrWithdrow?}',[SaversClientController::class, 'update'])->name('doEdit');
Route::delete('/delete/{saversClient}',[SaversClientController::class, 'destroy'])->name('doDelete'); 