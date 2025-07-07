<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;   //Api cotrollers
use App\Http\Controllers\TestController\TestController;
use App\Http\Controllers\OwnerController\OwnerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('test-flm',       [TestController::class, 'testFilament'])->name('test-filament');
Route::get('test-flm-owner', [TestController::class, 'testFilamentOwner'])->name('test.filament.owner');

// Auth (logged) users only
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Owner Controller list
    // Owners list all (regular Blade view)
    Route::get('owners', [OwnerController::class, 'index'])->name('owners.list');

    // Create new owner html form
    Route::get('/owner-create', [OwnerController::class, 'create'])->name('owner/create-new');

    // create new owner upon form request // saving owner form fields via POST
    Route::post('/owner/save',   [OwnerController::class, 'save']) ->name('owner.save');


    // Owner show one (below 2 possible ways of the same result, 2 different controller methods, one view)
	// Traditional route by id
    Route::get('/owner/{id}',     [OwnerController::class, 'showById'])->name('ownerOneId');
        
    // Implicit Route Model Binding
    Route::get('/owner/{owner}',  [OwnerController::class, 'show'])    ->name('ownerOne');

    // Edit owner form (Implicit Route Model Binding)
    Route::get('/owner-edit/{owner}', [ OwnerController::class, 'edit'])   ->name('ownerEdit');
		
    // update owner, handles edit owner form data // updating owner form fields via POST
    Route::put('/owner/update/{id}',      [ OwnerController::class, 'update'])  ->name('owner/update');
        
    // Delete owner // delete an owner
    Route::post('/owner-delete/{id}', [ OwnerController::class, 'delete']) ->name('owner/delete-one-owner');
    
});

require __DIR__.'/auth.php';





