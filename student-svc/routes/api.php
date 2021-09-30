<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\HomeworkController;
use App\Helpers\TokenHelper;

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

Route::post('/login', [StudentController::class, 'login'])->name('login');
Route::get('/service-token', function () {
    return TokenHelper::create(3000, 'teacher-svc')->generateServiceToken();
});

Route::middleware('auth.service')->get('/students/get', [StudentController::class, 'getStudents']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('homework')->name('homework.')->group(function () {
        Route::get('/get', [HomeworkController::class, 'getHomeworks'])->name('get');
        Route::post('/submit', [HomeworkController::class, 'submitHomework'])->name('submit');
    });
});
