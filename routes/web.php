<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProcedureController;
use App\Http\Controllers\Frontend\ProcedureController as FrontendProcedureController;
use App\Http\Controllers\Frontend\AppointmentController as FrontendAppointmentController;
use App\Http\Controllers\Frontend\TreatmentController as FrontendTreatmentController;
use App\Http\Controllers\Frontend\ProfileController as FrontendProfileController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TreatmentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Frontend\ReservationController;
use App\Http\Controllers\Frontend\DoctorsController;

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

// Frontend routes available to guest and patient
Route::group(['middleware' => ['is.patient.or.guest'], 'namespace' => 'Frontend'], function () {
    Route::get('procedures', [FrontendProcedureController::class, 'index'])->name('procedures');
    Route::get('/', [FrontendProcedureController::class, 'index'])->name('index');
});

// Frontend routes available only to logged in patient
Route::group(['middleware' => ['is.patient'], 'namespace' => 'Frontend'], function () {
    Route::get('appointments', [FrontendAppointmentController::class, 'index'])->name('appointments');
    Route::get('treatments', [FrontendTreatmentController::class, 'index'])->name('treatments');
    Route::get('reservations', [ReservationController::class, 'index'])->name('reservation');
    Route::get('profile', [FrontendProfileController::class, 'index'])->name('profile');
});

// Frontend API routes available to guest and patient
Route::group(['middleware' => ['is.patient.or.guest'], 'namespace' => 'Frontend', 'prefix' => 'api/front'], function () {
    Route::get('/procedures', [FrontendProcedureController::class, 'procedures'])->name('api.procedures');
});

// Frontend API routes available only to logged in patient
Route::group(['middleware' => ['is.patient'], 'namespace' => 'Frontend', 'prefix' => 'api/front'], function () {
    Route::get('/appointments', [FrontendAppointmentController::class, 'appointments'])->name('api.appointments');
    Route::get('/treatments', [FrontendTreatmentController::class, 'treatments'])->name('api.treatments');
    Route::get('/profile', [FrontendProfileController::class, 'profile'])->name('api.profile');
    Route::patch('/profile/update/{id}', [FrontendProfileController::class, 'update'])->name('api.profile.update');
    Route::get('/doctors', [DoctorsController::class, 'index'])->name('api.doctors');
    Route::get('/availableTimes', [ReservationController::class, 'availableTimes'])->name('api.availableTimes');
    Route::post('/appointments/store', [FrontendAppointmentController::class, 'store'])->name('api.appointments.store');
});

Route::group(['middleware' => ['is.admin.or.dentist'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');
    Route::get('/procedure', [ProcedureController::class, 'index'])->name('admin.procedure');
    Route::get('/patients', [UserController::class, 'patients'])->name('admin.patients');
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('admin.schedule');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('admin.appointment');
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
});

Route::group(['middleware' => ['is.admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/doctors', [UserController::class, 'doctors'])->name('admin.doctors');
});

Route::group(['middleware' => ['is.admin.or.dentist'], 'namespace' => 'Admin', 'prefix' => 'api'], function () {
    Route::get('/procedures', [ProcedureController::class, 'procedures'])->name('api.admin.procedures');
    Route::post('/procedures/store', [ProcedureController::class, 'store'])->name('api.admin.procedures.store');
    Route::patch('/procedures/update/{id}', [ProcedureController::class, 'update'])->name('api.admin.procedures.update');
    Route::post('/procedures/destroy/{id}', [ProcedureController::class, 'destroy'])->name('api.admin.procedures.destroy');

    Route::get('/users', [UserController::class, 'users'])->name('api.admin.users');
    Route::post('/users/store', [UserController::class, 'store'])->name('api.admin.users.store');
    Route::patch('/users/update/{id}', [UserController::class, 'update'])->name('api.admin.users.update');
    Route::post('/users/destroy/{id}', [UserController::class, 'destroy'])->name('api.admin.users.destroy');
    Route::post('/users/treatment/{id}', [UserController::class, 'treatment'])->name('api.admin.users.treatment');

    Route::get('/schedules', [ScheduleController::class, 'schedules'])->name('api.admin.schedules');
    Route::post('/schedules/store', [ScheduleController::class, 'store'])->name('api.admin.schedules.store');
    Route::patch('/schedules/update/{id}', [ScheduleController::class, 'update'])->name('api.admin.schedules.update');

    Route::get('/appointments', [AppointmentController::class, 'appointments'])->name('api.admin.appointments');
    Route::post('/appointments/approve/{id}', [AppointmentController::class, 'approve'])->name('api.admin.appointments.approve');
    Route::post('/appointments/cancel/{id}', [AppointmentController::class, 'cancel'])->name('api.admin.appointments.cancel');
    Route::get('/appointmentEvents', [AppointmentController::class, 'appointmentEvents'])->name('api.admin.appointmentEvents');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('api.admin.profile');

    Route::get('/treatments', [TreatmentController::class, 'treatments'])->name('api.admin.treatments');
    Route::post('/treatments/store', [TreatmentController::class, 'store'])->name('api.admin.treatments.store');
    Route::post('/treatments/approve/{id}', [TreatmentController::class, 'approve'])->name('api.admin.treatments.approve');
    Route::post('/treatments/cancel/{id}', [TreatmentController::class, 'cancel'])->name('api.admin.treatments.cancel');
    
    
});