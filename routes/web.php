<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\TaskController;
use App\Models\Record;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {

    Route::middleware('admin')->group(function () {
        // Locations Routes
        Route::get('/', [LocationController::class, 'index'])->name('locations.index');
        Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
        Route::post('/locations/store', [LocationController::class, 'store'])->name('locations.store');
        Route::put('/locations/{id}/update', [LocationController::class, 'update'])->name('locations.update');
        Route::delete('/locations/{id}/destroy', [LocationController::class, 'destroy'])->name('locations.destroy');

        // Tasks Routes
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
        Route::put('/tasks/{id}/update', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{id}/destroy', [TaskController::class, 'destroy'])->name('tasks.destroy');

        // Records Routes
        Route::get('/records', [RecordController::class, 'index'])->name('records.index');
        Route::post('/records/store', [RecordController::class, 'store'])->name('records.store');
        Route::put('/records/{id}/update', [RecordController::class, 'update'])->name('records.update');
        Route::delete('/records/{id}/destroy', [RecordController::class, 'destroy'])->name('records.destroy');

        Route::get('/users', [MainController::class, 'users'])->name('users.index');
        Route::put('/users/{id}', [MainController::class, 'usersUpdate'])->name('users.update');
        Route::delete('/users/{id}/destroy', [MainController::class, 'usersDestroy'])->name('users.destroy');

        Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard.index');
    });

    Route::middleware('presaler')->group(function () {
        Route::get('/', [RecordController::class, 'myRecords'])->name('my.records.index');
        Route::get('/my-records', [RecordController::class, 'myRecords'])->name('my.records.index');
        Route::put('/records/{id}/checkin', [RecordController::class, 'checkIn'])->name('checkin.records.update');
        Route::put('/records/{id}/checkout', [RecordController::class, 'checkOut'])->name('checkout.records.update');
        Route::put('/records/{id}/comment', [RecordController::class, 'comment'])->name('comment.records.update');
    });
});
