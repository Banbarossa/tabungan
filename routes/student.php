<?php

use App\Http\Controllers\PushSubscriptionController;
use Illuminate\Support\Facades\Route;

Route::domain('sima.pis.sch.id')->group(function () {

    Route::get('/', App\Livewire\Student\Auth\Login::class)->middleware('guest:student')->name('student.login');
    Route::get('/install', App\Livewire\Student\Install::class)->name('install');

    Route::middleware('auth:student')->as('student.')->prefix('student')->group(function () {
        Route::get('dashboard', App\Livewire\Student\LoginArea\StudentDashboard::class)->name('dashboard');
        Route::get('dompet', App\Livewire\Student\LoginArea\Wallet\Histories::class)->name('dompet');
        Route::get('dompet/tambah-saldo', App\Livewire\Student\LoginArea\Wallet\Topup::class)->name('topup-dompet');
        Route::get('dompet/statistik', App\Livewire\Student\LoginArea\Wallet\Statistik::class)->name('statistik-dompet');
        Route::get('dompet/informasi', App\Livewire\Student\LoginArea\Wallet\Informasi::class)->name('informasi-dompet');

        Route::get('profile/detail', App\Livewire\Student\LoginArea\Profile\Information::class)->name('profile.detail');
        Route::get('profile/password', App\Livewire\Student\LoginArea\Profile\Password::class)->name('profile.password');

        Route::get('tahfidz', App\Livewire\Student\LoginArea\Tahfidz\StatistikTahfidz::class)->name('tahfidz');
        Route::get('tahfidz-histories', App\Livewire\Student\LoginArea\Tahfidz\TahfidzHistory::class)->name('tahfidz.histories');
        Route::get('tahfidz-target', App\Livewire\Student\LoginArea\Tahfidz\TargetHafalan::class)->name('tahfidz.target');
        Route::get('tahfidz-information', App\Livewire\Student\LoginArea\Tahfidz\TahfidzInformation::class)->name('tahfidz.information');
    });

    Route::middleware('auth:student')->group(function () {
        Route::post('/push-subscriptions', [PushSubscriptionController::class, 'store']);

        Route::delete('/push-subscriptions', [PushSubscriptionController::class, 'destroy']);
    });


    Route::post('student/logout', App\Livewire\Actions\StudentLogout::class)
        ->name('student.logout')->middleware('auth:student');
});
