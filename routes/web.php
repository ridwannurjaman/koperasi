<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', function () {
    return view('auth/login');
});

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Anggota
    Route::get('/anggota', [App\Http\Controllers\AnggotaController::class, 'index'])->name('anggota.home');
    Route::get('/anggota/{id}', [App\Http\Controllers\AnggotaController::class, 'getAnggotaDetail'])->name('anggota.detail');
    Route::get('/anggota-barcode', [App\Http\Controllers\AnggotaController::class, 'cetakBarcode'])->name('anggota.cetakBarcode');
    Route::get('/anggota-barcode/{id}', [App\Http\Controllers\AnggotaController::class, 'cetakBarcodeAnggota'])->name('anggota.cetakBarcodeAnggota');
    Route::post('/listAnggota',[App\Http\Controllers\AnggotaController::class,'getAnggota'])->name('anggota.list');
    Route::post('/sAnggota',[App\Http\Controllers\AnggotaController::class,'saveAnggota'])->name('anggota.save');
    Route::post('/dAnggota',[App\Http\Controllers\AnggotaController::class,'deleteAnggota'])->name('anggota.delete');
    Route::post('/uAnggota',[App\Http\Controllers\AnggotaController::class,'updateAnggota'])->name('anggota.update');
    Route::post('/importAnggota',[App\Http\Controllers\AnggotaController::class,'import_excel'])->name('anggota.import');
    Route::get('/searchAnggota',[App\Http\Controllers\AnggotaController::class,'searchAnggota'])->name('anggota.search');


    // Jabatan
    Route::get('/jabatan', [App\Http\Controllers\JabatanController::class, 'index'])->name('jabatan.home');
    Route::post('/jabatan-list', [App\Http\Controllers\JabatanController::class, 'getJabatan'])->name('jabatan.list');
    Route::post('/jabatan-save', [App\Http\Controllers\JabatanController::class, 'saveJabatan'])->name('jabatan.save');
    Route::post('/jabatan-delete', [App\Http\Controllers\JabatanController::class, 'deleteJabatan'])->name('jabatan.delete');
    Route::post('/jabatan-update', [App\Http\Controllers\JabatanController::class, 'updateJabatan'])->name('jabatan.update');
    Route::post('/jabatan-undo', [App\Http\Controllers\JabatanController::class, 'undoJabatan'])->name('jabatan.undo');


    // Divisi
    Route::get('/divisi', [App\Http\Controllers\DivisiController::class, 'index'])->name('divisi.home');
    Route::post('/divisi-list', [App\Http\Controllers\DivisiController::class, 'getdivisi'])->name('divisi.list');
    Route::post('/divisi-save', [App\Http\Controllers\DivisiController::class, 'savedivisi'])->name('divisi.save');
    Route::post('/divisi-update', [App\Http\Controllers\DivisiController::class, 'updatedivisi'])->name('divisi.update');
    Route::post('/divisi-delete', [App\Http\Controllers\DivisiController::class, 'deletedivisi'])->name('divisi.delete');
    Route::post('/divisi-undo', [App\Http\Controllers\DivisiController::class, 'undodivisi'])->name('divisi.undo');

    // Barang
    Route::get('/barang', [App\Http\Controllers\BarangController::class, 'index'])->name('barang.home');
    Route::get('/barang-barcode/{id}', [App\Http\Controllers\BarangController::class, 'cetakBarcodeBarang'])->name('barang.barcode');
    Route::post('/barang-list', [App\Http\Controllers\BarangController::class, 'getBarang'])->name('barang.list');
    Route::get('/barang-search', [App\Http\Controllers\BarangController::class, 'getBarangAll'])->name('barang.search');
    Route::get('/barang-detail/{id}', [App\Http\Controllers\BarangController::class, 'getDetailBarang'])->name('barang.detail');
    Route::post('/barang-save', [App\Http\Controllers\BarangController::class, 'saveBarang'])->name('barang.save');
    Route::post('/barang-update', [App\Http\Controllers\BarangController::class, 'updateBarang'])->name('barang.update');
    Route::post('/barang-delete', [App\Http\Controllers\BarangController::class, 'deleteBarang'])->name('barang.delete');
    Route::post('/barang-undo', [App\Http\Controllers\BarangController::class, 'undoBarang'])->name('barang.undo');
    Route::post('/barang-saveStok', [App\Http\Controllers\BarangController::class, 'saveStok'])->name('barang.saveStock');
    Route::post('/barang-history/{id}', [App\Http\Controllers\BarangController::class, 'historyBarang'])->name('barang.history');
    Route::post('/barang-laporan' , [App\Http\Controllers\BarangController::class,'laporanStock'])->name('barang.laporan');
    Route::post('/barang-import' , [App\Http\Controllers\BarangController::class,'import_excel'])->name('barang.importExcel');
    Route::post('/barang-retur' , [App\Http\Controllers\BarangController::class,'returBarang'])->name('barang.returBarang');
     // Kategori
     Route::get('/kategori', [App\Http\Controllers\KategoriController::class, 'index'])->name('kategori.home');
     Route::post('/kategori-list', [App\Http\Controllers\KategoriController::class, 'getKategori'])->name('kategori.list');
     Route::post('/kategori-save', [App\Http\Controllers\KategoriController::class, 'saveKategori'])->name('kategori.save');
     Route::post('/kategori-delete', [App\Http\Controllers\KategoriController::class, 'deleteKategori'])->name('kategori.delete');
     Route::post('/kategori-update', [App\Http\Controllers\KategoriController::class, 'updateKategori'])->name('kategori.update');
     Route::post('/kategori-undo', [App\Http\Controllers\KategoriController::class, 'undoKategori'])->name('kategori.undo');

     // Kasir
     Route::get('/kasir', [App\Http\Controllers\KasirController::class, 'index'])->name('kasir.home');
     Route::post('/kasir-item', [App\Http\Controllers\KasirController::class, 'searchBarang'])->name('kasir.searchBarang');
     Route::post('/kasir-anggota', [App\Http\Controllers\KasirController::class, 'searchAnggota'])->name('kasir.anggota');
     Route::post('/kasir-save', [App\Http\Controllers\KasirController::class, 'saveTransaksi'])->name('kasir.save');

     // Laporan Transaksi
    Route::get('/transaksi', [App\Http\Controllers\LaporanTransaksiController::class, 'index'])->name('transaksi.home');
    Route::post('/transaksi-list', [App\Http\Controllers\LaporanTransaksiController::class, 'getDataTransaksi'])->name('transaksi.list');
    Route::post('/transaksi-list/{id}', [App\Http\Controllers\LaporanTransaksiController::class, 'getTransaksiDetail'])->name('transaksi.detail');

    Route::post('/transaksi-laporan' , [App\Http\Controllers\LaporanTransaksiController::class,'DownloadExportTransaksi'])->name('transaksi.laporan');
    
    // Retur
    Route::get('/retur', [App\Http\Controllers\ReturController::class, 'index'])->name('retur.home');
    Route::get('/retur-laporan', [App\Http\Controllers\ReturController::class, 'retur'])->name('retur.laporan');
    Route::get('/retur-barang', [App\Http\Controllers\ReturController::class, 'retur_barang'])->name('retur.laporan_barang');
    Route::post('/retur-item', [App\Http\Controllers\ReturController::class, 'returBarang'])->name('retur.returItem');
    Route::post('/retur-save', [App\Http\Controllers\ReturController::class, 'save'])->name('retur.save');
    Route::post('/retur-list', [App\Http\Controllers\ReturController::class, 'getDataRetur'])->name('retur.list');
    Route::post('/retur-list/{id}', [App\Http\Controllers\ReturController::class, 'getDetailRetur'])->name('retur.detail');
    Route::post('/retur-laporan' , [App\Http\Controllers\ReturController::class,'DownloadExportRetur'])->name('retur.laporan');
    Route::post('/retur-laporan-barang' , [App\Http\Controllers\ReturController::class,'DownloadExportReturBarang'])->name('retur.laporan.barang');
    Route::post('/retur-list' , [App\Http\Controllers\ReturController::class,'getDataReturBarang'])->name('retur_barang.list');


    // SImpan PINJAMA
    Route::get('/simpan-pinjam', [App\Http\Controllers\SimpanPinjamController::class, 'index'])->name('simpan_pinjam.home');
    Route::get('/simpan-detail/{id}', [App\Http\Controllers\SimpanPinjamController::class, 'detail'])->name('simpan_pinjam.detail');
    Route::post('/simpan-listDetail/{id}', [App\Http\Controllers\SimpanPinjamController::class, 'listDetail'])->name('simpan_pinjam.listDetail');
    Route::post('/simpan-bayar-detail/{id}', [App\Http\Controllers\SimpanPinjamController::class, 'bayarDetail'])->name('simpan_pinjam.bayarDetail');
    Route::post('/simpan-list', [App\Http\Controllers\SimpanPinjamController::class, 'list'])->name('simpan_pinjam.list');
    Route::post('/simpan-save', [App\Http\Controllers\SimpanPinjamController::class, 'save'])->name('simpan_pinjam.save');
    Route::post('/simpan-bayar', [App\Http\Controllers\SimpanPinjamController::class, 'bayar'])->name('simpan_pinjam.bayar');

    
});
