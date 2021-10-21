<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DecryptController;
use App\Http\Controllers\EncryptController;
use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\{Route, Auth};

use Illuminate\Http\Request;



Auth::routes(['verify' => true]);
Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});
Route::get('/re-login', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});
// Route::get('/forgot-password', function () {
//     return view('auth.passwords.reset');
// })->middleware('guest')->name('password.request');

Route::get('/', [HomeController::class, 'index']);


Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('encrypt')->group(function () {
        Route::get('/', 'EncryptController@index')->name('encrypt');
        Route::get('/{id?}', 'EncryptController@view')->name('view');
        Route::post('/', 'EncryptController@encryptRSA');
        Route::post('/stegano', 'EncryptController@steganography');
    });

    Route::get('/decrypt', [DecryptController::class, 'index'])->name('decrypt');

    Route::get('/refresh_csrf', function () {
        return response()->json(csrf_token());
    })->name('csrf.renew');
});
