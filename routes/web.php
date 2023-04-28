<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VocabulariesController;
use App\Models\Vocabularies;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/addVocabulariesPage', [VocabulariesController::class, 'index'])->name('vocabularies');
    Route::get('/getVocabularies', [VocabulariesController::class, 'getVacabularies'])->name('vocabularies.get');
    Route::post('/addVocabularies', [VocabulariesController::class, 'addVocabularies'])->name('vocabularies.add');

    Route::get('/getNotification', [VocabulariesController::class, 'getNotification'])->name('notification.get');
});

require __DIR__.'/auth.php';
