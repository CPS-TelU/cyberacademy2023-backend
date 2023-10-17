<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\AssistantController;

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

Route::post('/academy', [AcademyController::class, 'store'])->name('academy.store');
Route::post('/assistant/register', [AssistantController::class, 'register'])->name('assistant.register');
Route::post('/assistant/login', [AssistantController::class, 'login'])->name('assistant.login');
Route::get('/academy/quota', [AcademyController::class, 'countdownQuota'])->name('academy.quota');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/academy', [AcademyController::class, 'index'])->name('academy.index');
    Route::get('/academy/{id}', [AcademyController::class, 'show'])->name('academy.show');
    Route::patch('/academy/{id}', [AcademyController::class, 'update'])->name('academy.update');
    Route::post('/assistant/logout', [AssistantController::class, 'logout'])->name('assistant.logout');
    Route::delete('/academy/{id}', [AcademyController::class, 'destroy'])->name('academy.destroy');
});
