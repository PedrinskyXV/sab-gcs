<?php

use App\Http\Controllers\Usuario;
use App\Models\User;
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
    $nUsers = User::all()->count();
    return Inertia::render('Dashboard', ['nUsers' => $nUsers]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('users', Usuario::class);
Route::get('users/profile/{id}', [Usuario::class, 'profile'])->middleware(['auth', 'verified'])->name('users.profile');


require __DIR__.'/auth.php';
