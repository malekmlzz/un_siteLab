<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DocterController;
use App\Http\Controllers\Admin\LaboratoryController;
use App\Http\Controllers\Admin\PatientsController;
use App\Http\Controllers\Admin\SonograpyController;
use App\Http\Controllers\Admin\VerifyUserController;
use App\Http\Controllers\Auth\Login\AdminLoginController;
use App\Http\Controllers\Auth\Login\LabDocterSonoLoginController;
use App\Http\Controllers\Auth\LogOut\LogOutController;
use App\Http\Controllers\Auth\Register\LabDocterSonoController;
use App\Http\Controllers\Auth\Restpassword\RestPasswordController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\ChangePasswordCnotroller;
use App\Http\Controllers\Home\DoctersDashbordeController;
use App\Http\Controllers\Home\LaboratoriesDashbordeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('register')->group(function () {
        Route::post('users', [LabDocterSonoController::class, 'register'])->middleware('labDocterSono.registration');
    });
    Route::prefix('restPassword')->group(function () {
        Route::post('sendCode', [RestPasswordController::class, 'sendPasswordRestCode']);
        Route::post('vrifyCode/{user_id}', [RestPasswordController::class, 'verifyPasswordRestCode']);
    });
    Route::get('logout', [LogOutController::class, 'logout'])->middleware('jwt.auth');
    Route::prefix('login')->group(function () {
        Route::post('admin', [AdminLoginController::class, 'login']);
        Route::middleware(['admin.approval'])->group(function () {
            Route::post('users', [LabDocterSonoLoginController::class, 'login']);
        });
    });

    Route::post('admin/store', [AdminController::class, 'store']);
    Route::get('download/experiment/{experiment_id}', [LaboratoriesDashbordeController::class, 'downloadSorce']);
    Route::middleware(['jwt.auth'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('', [AdminController::class, 'index']);
            Route::delete('delete/{docter_id}', [AdminController::class, 'destroy']);

            Route::get('verifyUser/{user_id}', [VerifyUserController::class, 'verifyUser']);

            Route::get('dashborad', [AdminDashboardController::class, 'adminDashborad']);

            Route::get('patient', [PatientsController::class, 'index']);

            Route::prefix('docter')->group(function () {
                Route::get('', [DocterController::class, 'index']);
                Route::post('store', [DocterController::class, 'store']);
                Route::delete('delete/{docter_id}', [DocterController::class, 'destroy']);
            });
            Route::prefix('laboratory')->group(function () {
                Route::get('', [LaboratoryController::class, 'index']);
                Route::post('store', [LaboratoryController::class, 'store']);
                Route::delete('delete/{laboratory_id} ', [LaboratoryController::class, 'destroy']);
            });
            Route::prefix('sonography')->group(function () {
                Route::get('', [SonograpyController::class, 'index']);
                Route::post('store', [SonograpyController::class, 'store']);
                Route::delete('delete/{sonography_id} ', [SonograpyController::class, 'destroy']);
            });
        });
        Route::post('laboratory/dashborad/store', [LaboratoriesDashbordeController::class, 'store']);
        Route::post('docter/dashborad/serach', [DoctersDashbordeController::class, 'serach']);
        Route::post('changePassword', [ChangePasswordCnotroller::class, 'changePassword']);
    });
});