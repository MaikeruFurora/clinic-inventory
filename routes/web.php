<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
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



// Auth route
Route::middleware(['guest:web', 'preventBackHistory'])->name('auth.')->group(function () {
    Route::get('/', function () {return view('auth/login');})->name('form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

//logout
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['auth:web','preventBackHistory','administrator'])->name('administrator.')->prefix('administrator/')->group(function(){
    Route::get('dashboard',[AdministratorController::class,'dashboard'])->name('dashboard');

    //patient controller function and design
    Route::get('patient',[PatientController::class,'patient'])->name('patient');
    Route::get('patient/list',[PatientController::class,'patientList']);

     //user controller function and design
     Route::get('user',[UserController::class,'user'])->name('user');
     Route::get('user/find/{id}',[UserController::class,'findUser']);
     Route::get('user/list',[UserController::class,'userList']);
     Route::post('user/change-status/{user}/{status}',[UserController::class,'changeStatus']);
     Route::post('user/store',[UserController::class,'store']);
     Route::post('user/change-password',[UserController::class,'changePassword']);

    //medicine controller function and design
    Route::get('medicine',[MedicineController::class,'medicine'])->name('medicine');
    Route::get('medicine/list',[MedicineController::class,'medicineList']);

    //expenses controller function and design
    Route::get('expenses',[ExpensesController::class,'expenses'])->name('expenses');
    Route::get('expenses/list',[ExpensesController::class,'expensesList']);
});

Route::middleware(['auth:web','preventBackHistory','nurse'])->name('nurse.')->prefix('nurse/')->group(function(){
    Route::get('dashboard',[NurseController::class,'dashboard'])->name('dashboard');
});
