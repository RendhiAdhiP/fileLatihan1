<?php

use App\Http\Controllers\Api\ApplyingJobController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobVacancyController;
use App\Http\Controllers\Api\RequestValidationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix'=>'/v1'], function(){
    Route::Group(['prefix'=>'/auth'], function(){
        Route::post('/login',[AuthController::class, 'login']);
        Route::post('/logout',[AuthController::class, 'logout']);
    });

    Route::middleware(['check'])->group(function(){
        Route::post('/validations',[RequestValidationController::class, 'postValidation']);
        Route::get('/validations',[RequestValidationController::class, 'getValidation']);

        Route::get('/job_vacancies',[JobVacancyController::class, 'getJob']);
        Route::get('/job_vacancies/{id}',[JobVacancyController::class, 'detailJob']);
        
        Route::post('/applications',[ApplyingJobController::class, 'applyingJob']);
        Route::post('/applications/{id}',[ApplyingJobController::class, 'detailJob']);
        Route::get('/applications',[ApplyingJobController::class, 'getSuccessApply']);

        
    });
});