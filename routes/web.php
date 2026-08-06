<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\BukuController;
use App\Http\Controllers\Master\AnggotaController;
use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\Laporan\LaporanBukuController;
use App\Http\Controllers\Laporan\LaporanAnggotaController;
use App\Http\Controllers\Laporan\LaporanPeminjamanController;
use App\Http\Controllers\Laporan\LaporanPengembalianController;
use App\Http\Controllers\Laporan\LaporanPengunjungController;
use App\Http\Controllers\Transaksi\PeminjamanController;
use App\Http\Controllers\Transaksi\PengembalianController;
use App\Http\Controllers\Pengunjung\PengunjungController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// landing page
Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/search-books', [HomeController::class, 'searchBooks'])->name('books.search');
Route::get('/books', [HomeController::class, 'books'])->name('books.index');
Route::get('/books/{id_buku}', [HomeController::class, 'show'])->name('books.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


Route::get('/logout-test', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login');
});

    //Route Admin
   Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::prefix('master')->name('master.')->group(function () {
            Route::put('/buku/{id}', [BukuController::class, 'update']) ->name('buku.update');
            Route::resource('kategori', KategoriController::class);
            Route::resource('buku', BukuController::class);
            
            Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
            Route::post('/anggota/store', [AnggotaController::class, 'store'])->name('anggota.store');
            Route::put('/anggota/{id}',[AnggotaController::class, 'update'])->name('anggota.update');
            Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
        });
       

        Route::prefix('pengunjung')->name('pengunjung.')->group(function () {
            Route::get('/', [PengunjungController::class, 'index'])->name('index');
            Route::post('/store', [PengunjungController::class, 'store'])->name('store');
            Route::put('/update/{id}', [PengunjungController::class, 'update'])->name('update');
            Route::delete('/pengunjung/{id}', [PengunjungController::class, 'destroy'])->name('pengunjung.destroy');
            Route::delete('/destroy/{id}', [PengunjungController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('transaksi')->name('transaksi.')->group(function () {
            Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
                Route::get('/', [PeminjamanController::class, 'index'])->name('index');
                Route::post('/store', [PeminjamanController::class, 'store'])->name('store');
                Route::get('/{id}', [PeminjamanController::class, 'show'])->name('show');
                Route::put('/update/{id}', [PeminjamanController::class, 'update'])->name('update');
                Route::delete('/destroy/{id}', [PeminjamanController::class, 'destroy'])->name('destroy');
                Route::post('/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('kembali');
            });

            Route::prefix('pengembalian')->name('pengembalian.')->group(function(){
                Route::get('/',[PengembalianController::class, 'index'])->name('index');
                Route::post('/store/{id}',[PengembalianController::class, 'store'])->name('store');
                Route::delete('/destroy/{id}', [PengembalianController::class, 'destroy'])->name('destroy');
                Route::put('/{id}/batal', [PengembalianController::class,'batal'])->name('batal');
            });
        });

 
        //LAPORAN
        Route::prefix('laporan')->name('laporan.')->group(function(){
            Route::get('/buku',[LaporanBukuController::class, 'index'])->name('buku');
            Route::get('/laporan-buku/excel', [LaporanBukuController::class, 'exportExcel'])->name('buku.excel');
            Route::get('/laporan-buku/pdf', [LaporanBukuController::class, 'exportPdf'])->name('buku.pdf');

            Route::get('/anggota',[LaporanAnggotaController::class, 'index'])->name('anggota');
            Route::get('/laporan-anggota/excel', [LaporanAnggotaController::class, 'exportExcel'])->name('anggota.excel');
            Route::get('/laporan-anggota/pdf', [LaporanAnggotaController::class, 'exportPdf'])->name('anggota.pdf');

            Route::get('/peminjaman',[LaporanPeminjamanController::class, 'index'])->name('peminjaman');
            Route::get('/laporan/peminjaman/excel',[LaporanPeminjamanController::class,'exportPeminjamanExcel'])->name('peminjaman.excel');
            Route::get('/laporan/peminjaman/pdf',[LaporanPeminjamanController::class,'exportPeminjamanPdf'])->name('peminjaman.pdf');
            
            Route::get('/pengembalian',[LaporanPengembalianController::class, 'index'])->name('pengembalian');
            Route::get('/pengembalian', [LaporanPengembalianController::class, 'index'])->name('pengembalian');
            Route::get('/laporan-pengembalian/excel', [LaporanPengembalianController::class, 'exportExcel'])->name('pengembalian.excel');
            Route::get('/laporan-pengembalian/pdf', [LaporanPengembalianController::class, 'exportPdf'])->name('pengembalian.pdf');
           
            Route::get('/pengunjung',[LaporanPengunjungController::class, 'index'])->name('pengunjung'); 
            Route::get('/laporan-pengunjung/excel', [LaporanPengunjungController::class, 'exportExcel']) ->name('pengunjung.excel');
            Route::get('/laporan-pengunjung/pdf', [LaporanPengunjungController::class, 'exportPdf']) ->name('pengunjung.pdf');
        });

        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/',[ProfileController::class, 'index'])->name('index');
            Route::post('/update',[ProfileController::class, 'update'])->name('update');
            Route::post('/password',[ProfileController::class, 'updatePassword'])->name('password');
        });
    });






    // Routes untuk user
    Route::middleware('user')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user');
    });

    

    
});

require __DIR__.'/auth.php';
