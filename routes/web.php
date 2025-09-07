<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FeedbackController;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', function () {
    return view('configurator');
})->name('home');

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/order/{uuid}', [OrderController::class, 'show']);

// Static pages: About and Contacts
Route::view('/about', 'about')->name('about');
Route::view('/contacts', 'contacts')->name('contacts');

// Legal pages
Route::view('/user-agreement', 'legal.user-agreement')->name('legal.user_agreement');
Route::view('/privacy-policy', 'legal.privacy-policy')->name('legal.privacy');
Route::view('/cookies', 'legal.cookies')->name('legal.cookies');
Route::view('/requisites', 'legal.requisites')->name('legal.requisites');

// Help section (+ moved former services pages)
Route::prefix('help')->name('help.')->group(function () {
    Route::view('/', 'help.index')->name('index');
    Route::view('/how-to-order', 'help.how-to-order')->name('how_to_order');
    Route::view('/delivery', 'help.delivery')->name('delivery');
    Route::view('/payment', 'help.payment')->name('payment');
    Route::view('/returns', 'help.returns')->name('returns');
    Route::view('/faq', 'help.faq')->name('faq');

    // former /services/* pages
    Route::view('/logo-print', 'help.logo-print')->name('logo_print');
    Route::view('/fullprint', 'help.fullprint')->name('fullprint');
    Route::view('/logo-design', 'help.logo-design')->name('logo_design');
});

// Permanent redirects from old services URLs
Route::redirect('/services', '/help', 301);
Route::redirect('/services/logo-print', '/help/logo-print', 301);
Route::redirect('/services/fullprint', '/help/fullprint', 301);
Route::redirect('/services/logo-design', '/help/logo-design', 301);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

// Feedback / contact form (non‑Vite, plain POST endpoint)
Route::post('/feedback', [FeedbackController::class, 'send'])->name('feedback.send');
