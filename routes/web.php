<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');



Route::group(['middleware'=>['auth','can:admin']],function(){
    Route::get('dashboard',\App\Livewire\Admin\Dashboard\MasterDasboard::class)->name('dashboard');
});

Route::group(['middleware'=>['auth','can:cashier'],'as'=>'cashier.'],function(){
    Route::get('home',\App\Livewire\Cashier\CashierDashboard::class)->name('home');
    Route::get('cashier-transaction',\App\Livewire\Cashier\CashierTransaction::class)->name('transaction');
});


Route::group(['middleware'=>['auth','can:admin'],],function(){
    Route::group(['as'=>'account.','prefix'=>'account'],function(){
        Route::get('/',\App\Livewire\Admin\Account\MasterAccount::class);
        Route::get('/create',\App\Livewire\Admin\Account\AccountCreate::class)->name('create');
        Route::get('{code}/edit',\App\Livewire\Admin\Account\AccountCreate::class)->name('edit');
    });
});

Route::get('/transaction',\App\Livewire\Admin\Transaction\MasterTransaction::class)->name('transaction')->middleware(['auth','can:admin-cashier']);
Route::get('/transaction/setor/{code}',\App\Livewire\Admin\Transaction\SetorTransaction::class)->name('transaction.setor')->middleware(['auth','can:admin']);



Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
