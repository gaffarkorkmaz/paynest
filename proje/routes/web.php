<?php
/*
***********************************************************
Adı Soyadı: Gaffar Korkmaz
Öğrenci Numarası: 262484021
***********************************************************
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ApiPaymentController;

//
Route::get('/fatura/{id}/{invoiceid}', [InvoiceController::class, 'fatura_show'])->name("fatura.show");
Route::post('/fatura/{id}/{invoiceid}', [PaymentController::class, 'payment'])->name("fatura.payment");
Route::post('/{gateway}/callback', [PaymentController::class, 'callback'])->name("fatura.callback");
Route::get('/urun/{url}', [InvoiceController::class, 'urun_goruntule'])->name("urun.goruntule");
Route::post('/urun-al/{url}', [InvoiceController::class, 'urun_al'])->name("urun.post");
Route::get('/{gateway}/odeme/{id}', [ApiPaymentController::class, 'iframePayment'])->name("iframe.payment");
Route::any('/odeme/basarili/{id}', [ApiPaymentController::class, 'basarili'])->name("odeme.basarili");
Route::any('/odeme/basarisiz/{id}', [ApiPaymentController::class, 'basarisiz'])->name("odeme.basarisi");

Route::post('/api/v1/createpayment', [ApiPaymentController::class, 'createpayment'])->name("api.v1.createpayment");



Route::middleware('guest')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name("login");
    Route::post('/giris', [UserController::class, 'login'])->name("login.post");

});

Route::middleware('auth')->group(function () {
    Route::get('/anasayfa', [DashboardController::class, 'index'])->name("dashboard");
    Route::get('/cikis-yap', [UserController::class, 'logout'])->name("cikis-yap");

    //FATURA
    Route::get('/fatura-olustur', [InvoiceController::class, 'fatura'])->name("fatura");
    Route::post('/fatura-olustur', [InvoiceController::class, 'fatura_store'])->name("fatura.store");
    Route::get('/faturalar', [InvoiceController::class, 'faturalar'])->name("faturalar");
    Route::get('/fatura-data', [InvoiceController::class, 'fatura_data'])->name("faturalar.data");
    Route::get('/duzenle/fatura/{id}', [InvoiceController::class, 'fatura_edit'])->name("fatura.edit");
    Route::get('/sil/fatura/{id}', [InvoiceController::class, 'fatura_sil'])->name("fatura.sil");
    Route::post('/duzenle/fatura/{id}', [InvoiceController::class, 'fatura_guncelle'])->name("faturaedit");


    //URUNLER
    Route::get('/urunler', [InvoiceController::class, 'urunler'])->name("urunler");
    Route::get('/urun-data', [InvoiceController::class, 'urun_data'])->name("urun.data");
    Route::get('/urun-ekle', [InvoiceController::class, 'urun_ekle'])->name("urun.ekle");
    Route::post('/urun-store', [InvoiceController::class, 'urun_store'])->name("urun.store");

    Route::get('/urun-sil/{id}', [InvoiceController::class, 'urun_sil'])->name("urun.sil");
    Route::get('/urun-duzenle/{id}', [InvoiceController::class, 'urun_duzenle'])->name("urun.duzenle");
    Route::post('/urun-guncelle/{id}', [InvoiceController::class, 'urun_guncelle'])->name("urun.guncelle");

    Route::get('/pos-ayarlar', [PosController::class, 'index'])->name("pos.ayarlar");

    //AYARLAR
    Route::get('/ayarlar', [GeneralController::class, 'ayarlar'])->name("ayarlar");
    Route::post('/pos-ayar', [GeneralController::class, 'posayar'])->name("ayarlar.pos");
    Route::get('/aktif-et/{id}', [GeneralController::class, 'aktif'])->name("aktif-et");
    Route::get('/pasif-et/{id}', [GeneralController::class, 'pasif'])->name("pasif-et");
    Route::post('/sirket-duzenleme', [GeneralController::class, 'sirket_duzen'])->name("sirket.post");
    Route::post('/profil-duzenle', [GeneralController::class, 'profil_duzen'])->name("profil.post");


    //KEY
    Route::post('/key-kaydet', [PosController::class, 'apikey_store'])->name("apikey.store");
    Route::get('/key-sil/{id}', [PosController::class, 'apikey_sil'])->name("apikey.delete");
    Route::get('/key-kapat/{id}', [PosController::class, 'apikey_kapat'])->name("apikey.kapat");

    //MÜŞTERİ
    Route::get('/musteri-olustur', [InvoiceController::class, 'musteri'])->name("musteri");
    Route::post('/musteri-olustur', [InvoiceController::class, 'musteri_store'])->name("musteri.store");
    Route::get('/musteriler', [InvoiceController::class, 'musteriler'])->name("musteriler");
    Route::get('/musteri-data', [InvoiceController::class, 'musteri_data'])->name("musteri.data");
    Route::get('/goruntule/musteri/{id}', [InvoiceController::class, 'musteri_goruntule'])->name("musteri.goruntule");
    Route::get('/duzenle/musteri/{id}', [InvoiceController::class, 'musteri_duzenle'])->name("musteri.duzenle");
    Route::get('/sil/musteri/{id}', [InvoiceController::class, 'musteri_sil'])->name("musteri.sil");
    Route::post('/duzenle/musteri/{id}', [InvoiceController::class, 'musteri_guncelle'])->name("musteri.guncelle");

});
