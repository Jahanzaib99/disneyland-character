<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VotingController;
use App\Models\Character;
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
    return view('welcome');
});

// Voting Routes
Route::get('/vote', [VotingController::class, 'showVoteScreen'])->name('vote');
Route::post('/vote', [VotingController::class, 'registerVote'])->name('vote.store');
Route::get('/thank-you', [VotingController::class, 'showThankYouScreen']);


Route::get('/dashboard', function() {
    $characters = Character::all();
    return view('dashboard', compact('characters'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('admin/chart-data', [VotingController::class, 'adminDashboard'])->name('dashboard.chart');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    // Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('characters', CharacterController::class);

    // Users
    Route::resource('users', UsersController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'characterPopularityReport'])->name('admin.characterReport');
});

require __DIR__.'/auth.php';
