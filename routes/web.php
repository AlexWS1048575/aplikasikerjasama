<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CorporationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// dasar adminlte
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin/pages', [App\Http\Controllers\HomeController::class, 'pages'])->name('pages');
Route::get('/admin/pages2', [App\Http\Controllers\HomeController::class, 'pages2'])->name('pages2');

// pengguna
Route::resource('users', \App\Http\Controllers\UserController::class)
    ->middleware('auth');

// kerja sama
Route::resource('corporations', \App\Http\Controllers\CorporationController::class)
    ->middleware('auth');

// instansi
Route::resource('organizations', \App\Http\Controllers\OrganizationController::class)
    ->middleware('auth');

// gambar
Route::resource('pictures', \App\Http\Controllers\PictureController::class)
    ->middleware('auth');

// role
Route::resource('roles', \App\Http\Controllers\RoleController::class)
    ->middleware('auth');

// post
Route::resource('posts', PostController::class);

// permohonan
Route::resource('wishes', \App\Http\Controllers\WishController::class)
    ->middleware('auth');

// ganti password
Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');

// grafik
Route::get('/pie', [App\Http\Controllers\ChartController::class, 'index'])->name('pie');

// route login baru
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

// cetak pdf
Route::get('/downloadpdf', [App\Http\Controllers\CorporationController::class, 'downloadpdf'])->name('corporations.downloadpdf');

// ekspor ke excel
Route::get('/exportexcel', [App\Http\Controllers\CorporationController::class, 'exportexcel'])->name('corporations.exportexcel');

// import excel ke web
Route::get('/importexcel', [App\Http\Controllers\CorporationController::class, 'viewimport'])->name('corporations.viewimport');
Route::post('/importexcel', [App\Http\Controllers\CorporationController::class, 'importexcel'])->name('corporations.importexcel');

// faq
Route::get('/faqs', [App\Http\Controllers\FAQController::class, 'index'])->name('faqs.index');

// user guide
Route::get('/guides', [App\Http\Controllers\GuideController::class, 'index'])->name('guides.index');

// tandai semua notifikasi sudah terbaca
Route::post('/mark-as-read', [App\Http\Controllers\HomeController::class, 'markNotification'])->name('markNotification');

// set status menjadi disetujui di modul kerjasama
Route::get('/setasapproved/{Sid}', [App\Http\Controllers\CorporationController::class, 'setasapproved'])->name('corporations.setasapproved');

// set status menjadi in progress di modul kerjasama
Route::get('/setasrevisions/{Sid}', [App\Http\Controllers\CorporationController::class, 'setasrevisions'])->name('corporations.setasrevisions');

// ganti profil
Route::get('/change-profile', [App\Http\Controllers\HomeController::class, 'changeProfile'])->name('change-profile');
Route::post('/change-profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('update-profile');

// upload multiple berkas
Route::controller(FileController::class)->group(function(){
    Route::get('file-upload', 'index');
    Route::post('file-upload', 'store')->name('file.store');
});

// set status menjadi disetujui di modul permohonan kerjasama
Route::get('/wishcometrue/{Sid}', [App\Http\Controllers\WishController::class, 'wishcometrue'])->name('wishes.wishcometrue');

// set status menjadi in progress di modul permohonan kerjasama
Route::get('/wishcancelled/{Sid}', [App\Http\Controllers\WishController::class, 'wishcancelled'])->name('wishes.wishcancelled');