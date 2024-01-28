<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\ChordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TabController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('/tabulaturi', TabController::class)
    ->names('tabs')
    ->parameters(['tabulaturi' => 'tab']);
Route::resource('/artisti', ArtistController::class)
    ->names('artists')
    ->parameters(['artisti' => 'artist']);
Route::resource('/acorduri', ChordController::class)
    ->names('chords')
    ->parameters(['acorduri' => 'chord']);

Route::get('/utilizatori', [UserController::class, 'index'])->name('users.index');
Route::get('/utilizatori/{user}', [UserController::class, 'show'])->name('users.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
