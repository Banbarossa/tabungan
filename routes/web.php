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
    Route::get('calendar',\App\Livewire\CalendarDetail::class)->name('calendar');
    Route::get('/calendar-events',[\App\Http\Controllers\CalenderEventController::class,'getCalendarEvents'])->name('calender-event');
    Route::get('santri-absen',[\App\Http\Controllers\GetStudentApi::class,'getDataAbsen'])->name('import-data-absen');
    Route::get('daily-history',\App\Livewire\Admin\Transaction\DailyHistory::class)->name('daily-history');


    Route::group(['as'=>'account.','prefix'=>'account'],function(){
        Route::get('/{status}',\App\Livewire\Admin\Account\MasterAccount::class)->name('index');

        Route::get('/formulir/create',\App\Livewire\Admin\Account\AccountCreate::class)->name('create');
        Route::get('{code}/edit',\App\Livewire\Admin\Account\AccountCreate::class)->name('edit');
        Route::get('/pdf/id-card',[\App\Http\Controllers\StudentCardController::class,'singleCard'])->name('all-card');
        Route::get('/pdf/id-card/{ids}',[\App\Http\Controllers\StudentCardController::class,'singleCard'])->name('single-card');
    });

    Route::group(['as'=>'user.','prefix'=>'user'],function(){
        Route::get('/admin',\App\Livewire\Admin\User\AdminManagement::class)->name('admin');
        Route::get('/cashier',\App\Livewire\Admin\User\CashierManagement::class)->name('cashier');
        Route::get('/detail-user/{code}',\App\Livewire\Admin\User\UserDetail::class)->name('detail');
    });

    Route::group(['as'=>'report.','prefix'=>'report'],function(){
        Route::get('/common-daily-report/{date}',\App\Livewire\Admin\Report\CommonDailyReport::class)->name('common-daily');
        Route::get('/daily-report/{date}',\App\Livewire\Admin\Report\DailyReport::class)->name('daily');
        Route::get('/daily-income-report/{date}',\App\Livewire\Admin\Report\DailyIncomeReport::class)->name('daily.income');
        Route::get('/daily-report-pdf/{date}',[\App\Http\Controllers\DailyReportController::class,'exportPdf'])->name('daily.pdf');
        Route::get('/cashier-report-pdf/{date}/{user_code}',[\App\Http\Controllers\DailyReportController::class,'byDateAndCashier'])->name('cashier.pdf');
        Route::get('/daily-report/{date}/{user_code}',\App\Livewire\Admin\Report\ByDateAndCashierReport::class)->name('by-date-user');
    });

    Route::group(['as'=>'whatsapp.','prefix'=>'whatsapp'],function(){
        Route::get('/history',\App\Livewire\Admin\Whatsapp\HistoryMessage::class)->name('history');
        Route::get('/setting',\App\Livewire\Admin\Whatsapp\SettingSendingMessage::class)->name('setting');
    });



});


Route::get('/transaction',\App\Livewire\Admin\Transaction\MasterTransaction::class)->name('transaction')->middleware(['auth','can:admin']);
Route::get('/transaction/setor/{code}',\App\Livewire\Admin\Transaction\SetorTransaction::class)->name('transaction.setor')->middleware(['auth','can:admin']);

Route::get('/daily-limit',\App\Livewire\Admin\Transaction\DailyLimitManagement::class)->name('daily-limit-management')->middleware(['auth','can:admin']);



// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
//     Volt::route('settings/password', 'settings.password')->name('settings.password');
//     Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
// });

require __DIR__.'/auth.php';
