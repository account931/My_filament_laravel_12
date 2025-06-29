<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api;   //Api cotrollers
use App\Http\Controllers\TestController\TestController;


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



//Protected Sanctum routes
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// ----------------------------- Open routes (do not require Passport/Sanctum ( does not require token in request) --------------------------------------
// ------ OwnerController API --------
Route::get('/owners',        [Api\OwnerController::class, 'index'])->name('api.owners.test');
Route::get('/owner/{owner}', [Api\OwnerController::class, 'show']) ->name('api/owner/'); //Implicit Route Model Binding
Route::post('/owner/create', [Api\OwnerController::class, 'store'])->name('api/owner/create');



// ----------------------------- End Open routes (do not require Passport/Sanctum ( does not require token in request) --------------------------------------






// ----------------------------- Open routes (do not require Passport( does not require token in request) --------------------------------------

//Route::put('/owner/update/{owner}',    [OwnerController::class, 'update']);
// ->name('api/owner/update');  //should be potected too
// User Api Registration/Login
//Route::post('/register', [AuthController::class, 'register'])->name('api/register');
//Route::post('/login',    [AuthController::class, 'login'])   ->name('api/login');



// ----------------------------- Passport Protected routes (requires token)-------------------------------