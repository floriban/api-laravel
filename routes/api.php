<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('auth/register', [AuthController::class, 'create']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('departaments', DepartamentController::class);

    Route::resource('employees', EmployeeController::class);
    Route::get('employees-all', [EmployeeController::class, 'all']);
    Route::get('employees-by-departaments', [EmployeeController::class, 'EmployeeByDepartament']);

    Route::get('auth/logout', [AuthController::class, 'logout']);
});
