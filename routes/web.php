<?php

use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\MenuController;
use App\Http\Controllers\Back\ReservationController;
use App\Http\Controllers\Back\TestimonialController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Front End atau Landing Page
Route::get('/', [FrontController::class, 'index'])->name('welcome');
// Halaman Menu
Route::get('/menus', [FrontController::class, 'allMenus'])->name('menus.index');
// Halaman Artikel
Route::get('/articles/{slug}', [FrontController::class, 'showArticle'])->name('articles.show');
// Public Route Testimoni Customer
Route::post('/testimonial/store', [FrontController::class, 'storeTestimonial'])->name('testimonial.store');
// Halaman Testimoni
Route::get('/ulasan-pelanggan', [FrontController::class, 'allTestimonials'])->name('testimonials.index');

Route::middleware('auth')->group(function() {
    // Dashboard Utama Admin
    Route::get('/beranda', [DashboardController::class, 'index'])->name('dashboard');

    // Menu
    Route::resource('menu', MenuController::class);
    Route::patch('menu/{menu}/toggle-status', [MenuController::class, 'toggleStatus'])->name('menu.toggle-status');

    // Artikel
    Route::resource('article', ArticleController::class);

    // Reservasi
    Route::resource('reservation', ReservationController::class);
    Route::put('reservation/{id}/status', [ReservationController::class, 'updateStatus'])->name('reservation.update-status');

    // Testimoni
    Route::get('testimonial', [TestimonialController::class, 'index'])->name('testimonial.index');
    Route::patch('testimonial/{testimonial}/toggle-approval', [TestimonialController::class, 'toggleApproval'])->name('testimonial.toggle-approval');
    Route::delete('testimonial/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonial.destroy');

    Route::group(['prefix' => 'laravel-filemanager'], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::get('/reservations/export-excel', [ReservationController::class, 'exportExcel'])->name('admin.reservations.export-excel');
    Route::get('/reservations/{id}/pdf', [ReservationController::class, 'downloadPdf'])->name('admin.reservations.pdf');
    Route::get('/reservation/{id}/print', [ReservationController::class, 'print'])->name('admin.reservation.print');
    // Route Hapus Reservasi
    Route::delete('/reservation/{id}', [ReservationController::class, 'destroy'])->name('admin.reservation.destroy');
    // Route Ubah Status Reservasi
    Route::patch('/reservation/{id}/update-status', [ReservationController::class, 'updateStatus'])->name('admin.reservation.update-status');
    Route::put('/reservations/{id}/status', [ReservationController::class, 'updateStatus'])->name('reservation.updateStatus');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
