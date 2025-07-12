<?php

use App\Http\Controllers\Api;
use App\Http\Controllers\Auth_Api\AuthController;
use Illuminate\Http\Request;   // Api cotrollers
use Illuminate\Support\Facades\Route; // Api login/register, e.x for Vue

/*
|--------------------------------------------------------------------------
| Api routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ---------------- Sanctum Protected routes (requires token) -------------------------

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route simply Protected by Sanctum (without Spatie RBAC), any user who logged via API Login Controller & obtained token, can access it
    Route::get('/owners/quantity', [Api\OwnerController::class, 'quantity'])->name('api.owners.quantity');

    // protected by Sanctum + Spatie RBAC (user must have permission 'view owner admin quantity')
    Route::get('/owners/quantity/admin', [Api\OwnerController::class, 'quantityAdmin'])->name('api.owners.quantity.admin');

});

// Route::get('/user', function (Request $request) {return $request->user();})->middleware('auth:sanctum');
// ---------------- End Sanctum Protected routes (requires token) -------------------------

// ----------------------------- Open routes (do not require Passport/Sanctum ( does not require token in request) --------------------------------------
// ------ OwnerController API --------
Route::get('/owners', [Api\OwnerController::class, 'index'])->name('api.owners.index');
Route::get('/owner/{owner}', [Api\OwnerController::class, 'show'])->name('api.owner'); // Implicit Route Model Binding
Route::post('/owner/create', [Api\OwnerController::class, 'store'])->name('api.owner.create');  // should be potected
Route::put('/owner/update/{owner}', [Api\OwnerController::class, 'update'])->name('api.owner.update');   // should be potected too
Route::delete('/owner/delete/{owner}', [Api\OwnerController::class, 'destroy'])->name('api.owner.destroy');   // should be potected too

// ----------------------------- End Open routes (do not require Passport/Sanctum ( does not require token in request) --------------------------------------

// User Api Registration/Login
Route::post('/register', [AuthController::class, 'register'])->name('api/register');
Route::post('/login', [AuthController::class, 'login'])->name('api/login');

// ----------------------------- Open routes (do not require Passport( does not require token in request) --------------------------------------

// ->name('api/owner/update');  //should be potected too
// User Api Registration/Login
// Route::post('/register', [AuthController::class, 'register'])->name('api/register');
// Route::post('/login',    [AuthController::class, 'login'])   ->name('api/login');

// ----------------------------- Passport Protected routes (requires token)-------------------------------
