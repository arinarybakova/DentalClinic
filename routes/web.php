<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProcedureController;
use App\Http\Controllers\Frontend\ProcedureController as FrontendProcedureController;
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
Route::post('logout', [AuthController::class, 'logout'])->name('logout'); 

Route::group(['namespace' => 'Frontend'], function () {
    Route::get('procedures', [FrontendProcedureController::class, 'index'])->name('procedures');
});

Route::get('/', [FrontendProcedureController::class, 'index'])->name('index');

Route::group(['middleware' => ['is.admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');
    Route::get('/procedure', [ProcedureController::class, 'index'])->name('admin.procedure');
    Route::get('/doctors', [UserController::class, 'doctors'])->name('admin.doctors');
    Route::get('/patients', [UserController::class, 'patients'])->name('admin.patients');
});

Route::group(['middleware' => ['is.admin'], 'namespace' => 'Admin', 'prefix' => 'api'], function () {
    Route::get('/procedures', [ProcedureController::class, 'procedures'])->name('api.admin.procedures');
    Route::post('/procedures/store', [ProcedureController::class, 'store'])->name('api.admin.procedures.store');
    Route::patch('/procedures/update/{id}', [ProcedureController::class, 'update'])->name('api.admin.procedures.update');
    Route::post('/procedures/destroy/{id}', [ProcedureController::class, 'destroy'])->name('api.admin.procedures.destroy');

    Route::get('/users', [UserController::class, 'users'])->name('api.admin.users');
    Route::post('/users/store', [UserController::class, 'store'])->name('api.admin.users.store');
    Route::patch('/users/update/{id}', [UserController::class, 'update'])->name('api.admin.users.update');
    Route::post('/users/destroy/{id}', [UserController::class, 'destroy'])->name('api.admin.users.destroy');
});

Route::group(['namespace' => 'Frontend', 'prefix' => 'api/front'], function () {
    Route::get('/procedures', [FrontendProcedureController::class, 'procedures'])->name('api.procedures');
});

// Route::get('/home', [HomeController::class, 'redirect']);

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::get('{any}', function(){
//     return view('app');
// })->where('any', '.*');

