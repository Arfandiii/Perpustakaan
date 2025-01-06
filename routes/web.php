<?php

use App\Helpers\DiceSimilarityHelper;
use App\Http\Controllers\Admin\BookCategoriesController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DiceSimilarityController;
use App\Http\Controllers\Admin\EduLevelsController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;


Route::match(['get'], '/dice-similarity', [DiceSimilarityController::class, 'index'])->name('dicesimilarity.index');
Route::get('/catalog/search', [BookController::class, 'searchBookUser'])->name('searchBookUser');

// Home Route
Route::get('/', [BookController::class, 'home'])->name('home');
Route::get('/catalog', [BookController::class, 'catalog'])->name('catalog');
Route::get('/about', fn() => view('about', ['title' => 'About']))->name('about');
Route::get('/contact', fn() => view('contact', ['title' => 'Contact']))->name('contact');
Route::get('/book/{slug}', [BookController::class, 'showUser'])->name('book.showUser');
Route::post('/contact/send', [ContactController::class, 'sendContact'])->name('contact.send');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
});

// Common User Routes (Authenticated)
Route::middleware(['auth'])->group(function () {
    // User Dashboard
    Route::middleware(['role:user'])->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard.user');
        Route::get('/dashboard/profile', [UserDashboardController::class, 'profile'])->name('profile');
        Route::put('/dashboard/profile/update', [UserDashboardController::class, 'updateProfile'])->name('updateProfile');
        Route::post('/dashboard/profile/update-password', [UserDashboardController::class, 'changePassword'])->name('changePassword');
        Route::get('/notifications', [UserDashboardController::class, 'notification'])->name('notification');
        Route::get('/loans/create/{book}', [LoanController::class, 'confirmLoanUser'])->name('loans.confirmLoan');
        Route::post('/loans/create/{book}/store', [LoanController::class, 'createLoanUser'])->name('loans.createLoan');
    });
    
    // Admin Dashboard
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/admin/settings', [AdminDashboardController::class, 'setting'])->name('settings');
        Route::post('/admin/settings/change-password', [AdminDashboardController::class, 'changePassword'])->name('changePassword');
        Route::put('/admin/settings/update-profile', [AdminDashboardController::class, 'updateProfile'])->name('updateProfile');
        Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
        Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
        
        // Manage Users
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/verify', [UserController::class, 'verify'])->name('users.verify');
        
        // Manage Books
        Route::resource('books', BookController::class);
        
        // Manage Book Categories
        Route::resource('categories', BookCategoriesController::class);
        
        // Manage Edu Levels
        Route::resource('edu-levels', EduLevelsController::class);
        
        // Manage Loans
        Route::get('/loans/{loanBook}/edit-loan', [LoanController::class, 'updateLoanBook'])->name('loans.editLoanBook');
        Route::patch('/loans/{loanBook}/update-loan', [LoanController::class, 'updateStatus'])->name('loans.updateLoanBook');
        Route::post('/loans/{id}/return', [LoanController::class, 'return'])->name('loans.return');
        Route::resource('loans', LoanController::class);
    });
});