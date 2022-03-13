<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
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
    Route::post('patient/list',[PatientController::class,'patientList']);
    Route::post('patient/store',[PatientController::class,'patientStore']);
    Route::get('patient/edit/{patient}',[PatientController::class,'patientEdit']);
        //medical record per patient function
        Route::get('patient/medical-record/{id}',[PatientController::class,'medicalRecord']);
        Route::get('patient/medical-record/list/{id}',[PatientController::class,'medicalRecordList']);
        Route::get('patient/medical-record/record/{medicalRecord}',[PatientController::class,'record']);
        Route::post('patient/medical-record/store',[PatientController::class,'medicalStore']);
            //perscription and inventory
            Route::get('patient/medical-record/prescription-inventory/{id}',[PatientController::class,'prescriptionAndInventory']);

     //user controller function and design
     Route::get('user',[UserController::class,'user'])->name('user');
     Route::get('user/find/{id}',[UserController::class,'findUser']);
     Route::get('user/privilege/{id}',[UserController::class,'privilegeStatus']);
     Route::get('user/list',[UserController::class,'userList']);
     Route::post('user/change-status/{user}/{status}',[UserController::class,'changeStatus']);
     Route::post('user/privilege-update',[UserController::class,'privilegeUpdate']);
     Route::post('user/store',[UserController::class,'store']);
     Route::post('user/change-password',[UserController::class,'changePassword']);

    //medicine controller function and design
    Route::get('medicine',[MedicineController::class,'medicine'])->name('medicine');
    Route::post('medicine/list',[MedicineController::class,'medicineList']);
    Route::get('medicine/edit/{id}',[MedicineController::class,'edit']);
    Route::post('medicine/store',[MedicineController::class,'store']);

    //equipment controller function and design
    Route::get('equipment',[EquipmentController::class,'equipment'])->name('equipment');
    Route::post('equipment/list',[EquipmentController::class,'equipmentList']);
    Route::get('equipment/edit/{id}',[EquipmentController::class,'edit']);
    Route::post('equipment/store',[EquipmentController::class,'store']);

    //expenses controller function and design
    Route::get('expenses',[ExpenseController::class,'expenses'])->name('expenses');
    Route::post('expenses/store',[ExpenseController::class,'store']);
    Route::get('expenses/list/{year}/{month}',[ExpenseController::class,'expensesList']);
    Route::get('expenses/edit/{expense}',[ExpenseController::class,'edit']);
    Route::get('expenses/bar-graph/{year}',[ExpenseController::class,'barGraph']);
    Route::get('expenses/generate-report/{start}/{end}/{type}',[ExpenseController::class,'generateReport']);

});

Route::middleware(['auth:web','preventBackHistory','nurse'])->name('nurse.')->prefix('nurse/')->group(function(){
    Route::get('dashboard',[NurseController::class,'dashboard'])->name('dashboard');
});

Route::get('/clear', function () { //-> tawagin mo to url sa browser -> 127.0.0.1:8000/clear
    Artisan::call('view:clear'); //   -> Clear all compiled files
    Artisan::call('route:clear'); //  -> Remove the route cache file 
    Artisan::call('optimize:clear'); //-> Remove the cache bootstrap files
    Artisan::call('event:clear'); //   -> clear all cache events and listener
    Artisan::call('config:clear'); //  -> Remove the configuration cache file
    Artisan::call('cache:clear'); //   -> Flush the application cache
    return back();
});
