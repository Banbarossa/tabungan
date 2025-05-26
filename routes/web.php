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
        Route::get('id-card',[\App\Http\Controllers\StudentCardController::class,'singleCard'])->name('all-card');
        Route::get('id-card/{code}',[\App\Http\Controllers\StudentCardController::class,'singleCard'])->name('single-card');
    });

    Route::group(['as'=>'user.','prefix'=>'user'],function(){
        Route::get('/admin',\App\Livewire\Admin\User\AdminManagement::class)->name('admin');
        Route::get('/cashier',\App\Livewire\Admin\User\CashierManagement::class)->name('cashier');
        Route::get('/detail-user/{code}',\App\Livewire\Admin\User\UserDetail::class)->name('detail');
    });

    Route::group(['as'=>'report.','prefix'=>'report'],function(){
        Route::get('/daily-report/{date}',\App\Livewire\Admin\Report\DailyReport::class)->name('daily');
        Route::get('/daily-report/{date}/{user_code}',\App\Livewire\Admin\Report\ByDateAndCashierReport::class)->name('by-date-user');
    });
});




Route::get('/transaction',\App\Livewire\Admin\Transaction\MasterTransaction::class)->name('transaction')->middleware(['auth','can:admin']);
Route::get('/transaction/setor/{code}',\App\Livewire\Admin\Transaction\SetorTransaction::class)->name('transaction.setor')->middleware(['auth','can:admin']);

Route::get('/daily-limit',\App\Livewire\Admin\Transaction\DailyLimitManagement::class)->name('daily-limit-management')->middleware(['auth','can:admin']);


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
