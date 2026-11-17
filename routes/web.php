
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ParkingAreaController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ParkingTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;

// HALAMAN UTAMA
Route::get('/', function () {
    return redirect()->route('login');
});

// LOGIN
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

});

// SEMUA PENGGUNA YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    // =====================================
    // DASHBOARD OWNER
    // =====================================
    Route::middleware('role:owner')->group(function () {

        Route::get('/owner/dashboard', [DashboardController::class, 'owner'])
            ->name('owner.dashboard');

    });


    // =====================================
    // FITUR KHUSUS ADMIN
    // =====================================
    Route::middleware('role:admin')->group(function () {

        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
            ->name('admin.dashboard');


        // REGISTER ADMIN / PETUGAS
        Route::get('/admin/register', [RegisterController::class, 'create'])
            ->name('register.create');

        Route::post('/admin/register', [RegisterController::class, 'store'])
            ->name('register.store');


        // CRUD USER
        Route::resource('users', UserController::class)
            ->except(['show']);


        // CRUD KENDARAAN
        Route::resource('kendaraan', KendaraanController::class)
            ->except(['show']);


        // CRUD TARIF
        Route::resource('tarif', TarifController::class)
            ->except(['show']);


        // CRUD AREA PARKIR
        Route::resource('areas', ParkingAreaController::class)
            ->except(['show']);


        // LOG AKTIVITAS KHUSUS ADMIN
        Route::get('/admin/activity-logs', [
            ActivityLogController::class,
            'index'
        ])->name('admin.activity-logs.index');

    });


    // =====================================
    // LAPORAN OWNER DAN ADMIN
    // =====================================
    Route::middleware('role:owner,admin')->group(function () {

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

    });


    // =====================================
    // DASHBOARD PETUGAS
    // =====================================
    Route::middleware('role:petugas')->group(function () {

        Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])
            ->name('petugas.dashboard');

    });


    // =====================================
    // MELIHAT TRANSAKSI
    // OWNER, ADMIN, DAN PETUGAS
    // =====================================
    Route::middleware('role:owner,admin,petugas')->group(function () {

        // DAFTAR TRANSAKSI
        Route::get('/transactions', [ParkingTransactionController::class, 'index'])
            ->name('transactions.index');


        // DETAIL TRANSAKSI
        Route::get('/transactions/{transaction}', [ParkingTransactionController::class, 'show'])
            ->whereNumber('transaction')
            ->name('transactions.show');


        // CETAK STRUK
        Route::get('/transactions/{transaction}/receipt', [ParkingTransactionController::class, 'receipt'])
            ->name('transactions.receipt');

    });


    // =====================================
    // OPERASIONAL PARKIR
    // ADMIN DAN PETUGAS
    // =====================================
    Route::middleware('role:admin,petugas')->group(function () {

        // FORM KENDARAAN MASUK
        Route::get('/transactions/create', [ParkingTransactionController::class, 'create'])
            ->name('transactions.create');


        // SIMPAN KENDARAAN MASUK
        Route::post('/transactions', [ParkingTransactionController::class, 'store'])
            ->name('transactions.store');


        // HAPUS TRANSAKSI
        Route::delete('/transactions/{transaction}', [ParkingTransactionController::class, 'destroy'])
            ->name('transactions.destroy');


        // FORM CHECKOUT
        Route::get('/transactions/{transaction}/checkout', [ParkingTransactionController::class, 'checkout'])
            ->name('transactions.checkout');


        // PROSES PEMBAYARAN
        Route::post('/transactions/{transaction}/checkout', [ParkingTransactionController::class, 'processCheckout'])
            ->name('transactions.processCheckout');


        // DAFTAR KENDARAAN PARKIR
        Route::get('/parking', [ParkingController::class, 'index'])
            ->name('parking.index');


        Route::get('/parking/create', [ParkingController::class, 'create'])
            ->name('parking.create');


        Route::post('/parking', [ParkingController::class, 'store'])
            ->name('parking.store');


        Route::post('/parking/{id}/checkout', [ParkingController::class, 'checkout'])
            ->name('parking.checkout');

    });

});
