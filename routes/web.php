<?php

use App\Http\Controllers\Admin\DoctorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProcedureController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\AuthController;
use App\Models\Procedure;

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



Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('register', [AuthController::class, 'registration'])->name('register');
Route::post('post-register', [AuthController::class, 'postRegister'])->name('register.post');

Route::get('/', [HomeController::class, 'index']);

Route::group(['middleware' => ['is.admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');
    Route::get('/procedure', [ProcedureController::class, 'index'])->name('admin.procedure');
    Route::get('/doctors', [DoctorController::class, 'index'])->name('admin.doctors');
});

Route::group(['middleware' => ['is.admin'], 'namespace' => 'Admin', 'prefix' => 'api'], function () {
    Route::get('/procedures', [ProcedureController::class, 'procedures'])->name('api.admin.procedures');
    Route::post('/procedures/store', [ProcedureController::class, 'store'])->name('api.admin.procedures.store');
    Route::patch('/procedures/update/{id}', [ProcedureController::class, 'update'])->name('api.admin.procedures.update');

    Route::get('/doctors', [DoctorController::class, 'doctors'])->name('api.admin.doctors');
});

// Route::get('/home', [HomeController::class, 'redirect']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Route::get('{any}', function(){
//     return view('app');
// })->where('any', '.*');

