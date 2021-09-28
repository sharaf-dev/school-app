<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
