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


Auth::routes([
    //'login' => false,
    'register' => false,
]);

Route::get('/', function () {
    return view('login');
})->name('home');
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/datatable', function () {
    return view('datatable');
})->name('datatable');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/users', [App\Http\Controllers\HomeController::class, 'users'])->name('users');

Route::group(['middleware' => 'auth'], function(){
    Route::group(['prefix'=>'admin', 'middleware' => 'admin'], function(){	
        Route::get('/', [App\Http\Controllers\AuthController::class, 'admin'])->name('admin');
        Route::get('/attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/byuser', [App\Http\Controllers\AttendanceController::class, 'byuser'])->name('attendance.byuser');
        Route::get('/attendance/create', [App\Http\Controllers\AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance/store', [App\Http\Controllers\AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance/ajax/single/{id?}', [App\Http\Controllers\AttendanceController::class, 'ajaxsingle'])->name('attendance.ajax.single');
        Route::put('/attendance/{id}', [App\Http\Controllers\AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('/attendance/{id}', [App\Http\Controllers\AttendanceController::class, 'destroy'])->name('attendance.destroy');
        Route::get('/attendance/{id}/delete', [App\Http\Controllers\AttendanceController::class, 'destroy'])->name('attendance.destroy');
        Route::get('/employee', [App\Http\Controllers\EmployeeController::class, 'tree'])->name('employee');
        Route::get('/settings', [App\Http\Controllers\SettingController::class, 'general'])->name('settings.general');
        Route::get('/users', [App\Http\Controllers\SettingController::class, 'general'])->name('settings.general');
    });
    Route::group(['prefix'=>'user'], function(){	
        Route::get('/', [App\Http\Controllers\AuthController::class, 'user'])->name('user');
        Route::get('/attendance', [App\Http\Controllers\AttendanceController::class, 'user'])->name('attendance.user');
    });
    Route::get('/checkin', [App\Http\Controllers\AttendanceController::class, 'checkin'])->name('checkin');
    Route::get('/checkout', [App\Http\Controllers\AttendanceController::class, 'checkout'])->name('checkout');
    
    Route::resource('leave',App\Http\Controllers\LeaveController::class);
});