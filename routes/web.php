<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfiguratorController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Livewire\Volt\Volt;
use Illuminate\Http\Request;

Route::get('/', [ConfiguratorController::class, 'index'])->name('home');
Route::get('/order/{uuid}', [OrderController::class, 'show'])->name('order.show');
Route::get('/checkout', [CheckoutController::class, 'showForm'])->name('checkout.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::post('/calculate', [ConfiguratorController::class, 'calculate']);
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::post('/checkout', [CheckoutController::class, 'form'])->name('checkout.form');
Route::post('/checkout/submit', [CheckoutController::class, 'submit'])->name('checkout.submit');
Route::post('/checkout/store-data', function (Request $request) {
    $data = [];

    foreach ($request->all() as $key => $value) {
        // Если это файл — пропускаем
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            continue;
        }

        // Если массив — сериализуем
        $data[$key] = is_array($value) ? json_encode($value) : $value;
    }

    session(['checkout_data' => $data]);

    return response()->noContent();
})->name('checkout.storeData');

require __DIR__.'/auth.php';
