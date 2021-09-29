<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\HomeworkController;

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
Route::middleware('auth.service')->get('/students/get', [StudentController::class, 'getStudents']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('homework')->name('homework.')->group(function () {
        Route::get('/get', [HomeworkController::class, 'getHomeworks'])->name('get');
    });
});
