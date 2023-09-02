<?php

use App\Http\Controllers\Admin\AprovalRegisterUsers;
use App\Http\Controllers\Admin\DocterController;
use App\Http\Controllers\Admin\LaboratoryController;
use App\Http\Controllers\Admin\PatientsController;
use App\Http\Controllers\Admin\SonograpyController;
use App\Http\Controllers\Admin\VerifyUserController;
use App\Http\Controllers\Auth\Login\AdminLoginController;
use App\Http\Controllers\Auth\Login\LabDocterSonoLoginController;
use App\Http\Controllers\Auth\LogOut\LogOutController;
use App\Http\Controllers\Auth\Register\AdminController;
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
        Route::post('admin', [AdminController::class, 'register'])->middleware('admin.registration');
        Route::post('users', [LabDocterSonoController::class, 'register'])->middleware('labDocterSono.registration');
    });
    Route::prefix('restPassword')->group(function () {
        Route::post('sendCode', [RestPasswordController::class, 'sendPasswordRestCode']);
        Route::post('vrifyCode', [RestPasswordController::class, 'verifyPasswordRestCode']);
    });
    Route::get('logout', [LogOutController::class, 'logout'])->middleware('jwt.auth');
    Route::prefix('login')->group(function () {
        Route::post('admin', [AdminLoginController::class, 'login']);
        Route::middleware(['admin.approval'])->group(function () {
            Route::post('laboratory', [LabDocterSonoLoginController::class, 'login']);
        });
    });

    Route::get('admin/verifyUser/{user_id}', [VerifyUserController::class, 'verifyUser']);
    Route::get('admin/changeRole/{user_id}', [VerifyUserController::class, 'changeRoleUser']);
    Route::middleware(['jwt.auth'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('patient', [PatientsController::class, 'index']);
            Route::prefix('docter')->group(function () {
                Route::get('', [DocterController::class, 'index']);
                Route::post('store', [DocterController::class, 'store']);
                Route::delete('delete/{docter_id}', [DocterController::class, 'destroy']);
            });
            Route::prefix('laboratory')->group(function () {
                Route::get('', [LaboratoryController::class, 'index']);
                Route::post('store', [LaboratoryController::class, 'store']);
                Route::delete('delete/{laboratory_id} ', [LaboratoryController::class, 'delete']);
            });
            Route::prefix('sonograpy')->group(function () {
                Route::get('', [SonograpyController::class, 'index']);
                Route::post('store', [SonograpyController::class, 'store']);
                Route::delete('delete/{sonograpy_id} ', [SonograpyController::class, 'delete']);
            });
            
        });
        Route::post('laboratory/dashborad/store', [LaboratoriesDashbordeController::class, 'store']);
        Route::get('download/experiment/{experiment_id}', [LaboratoriesDashbordeController::class, 'downloadSorce']);
        Route::post('docter/dashborad/serach', [DoctersDashbordeController::class, 'serach']);
        Route::post('changePassword', [ChangePasswordCnotroller::class, 'changePassword']);
    });
});
