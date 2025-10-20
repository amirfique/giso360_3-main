<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/signin', function () {
    return view('account-pages.signin');
})->name('signin')->middleware('guest');

Route::get('/signup', function () {
    return view('account-pages.signup');
})->name('signup')->middleware('guest');

Route::get('/sign-in', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('sign-in');

Route::post('/sign-in', [LoginController::class, 'store'])
    ->middleware('guest');

Route::get('/sign-up', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('sign-up');

Route::post('/sign-up', [RegisterController::class, 'store'])
    ->middleware('guest');

Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'store'])
    ->middleware('guest');

// Authenticated Routes (Both Admin and Student)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    
    // Main redirect - goes to appropriate dashboard based on role
    Route::get('/', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('teams.index');
    });

    // Dashboard - shows appropriate content based on role
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        // For students, show the regular dashboard
        return view('dashboard');
    })->name('dashboard');

    // Tables page - accessible to both
    Route::get('/tables', function () {
        return view('tables');
    })->name('tables');

    // Wallet page - accessible to both
    Route::get('/wallet', function () {
        return view('wallet');
    })->name('wallet');

    // Profile routes (accessible to both admin and students)
    Route::get('/profile', function () {
        return view('account-pages.profile');
    })->name('profile');

    Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('users.profile');
    Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update');
    Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Team Management
    Route::get('/teams', [AdminController::class, 'teams'])->name('teams');
    
    // Proposal Management
    Route::get('/proposals', [AdminController::class, 'proposals'])->name('proposals');
    Route::patch('/proposals/{proposal}/status', [AdminController::class, 'updateProposalStatus'])->name('proposals.updateStatus');
    
    // Report Management
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::patch('/reports/{report}/status', [AdminController::class, 'updateReportStatus'])->name('reports.updateStatus');
    
    // Expense Management
    Route::get('/expenses', [AdminController::class, 'expenses'])->name('expenses');
});

// Student Routes - Protected with student middleware
Route::middleware(['auth', 'student'])->group(function () {
    // Team routes
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::post('/teams/join', [TeamController::class, 'join'])->name('teams.join');
    Route::get('/teams/{team:slug}', [TeamController::class, 'show'])->name('teams.show');

    // Proposals routes
    Route::post('/teams/{team}/proposals', [ProposalController::class, 'store'])->name('proposals.store');
    Route::get('/proposals/{proposal}/download', [ProposalController::class, 'download'])->name('proposals.download');
    Route::patch('/proposals/{proposal}/status', [ProposalController::class, 'updateStatus'])->name('proposals.updateStatus');
    Route::delete('/proposals/{proposal}', [ProposalController::class, 'destroy'])->name('proposals.destroy');

    // Reports routes
    Route::post('/teams/{team}/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}/download', [ReportController::class, 'download'])->name('reports.download');
    Route::patch('/reports/{report}/status', [ReportController::class, 'updateStatus'])->name('reports.updateStatus');
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');

    // Finance routes
    Route::get('/teams/{team}/finance', [FinanceController::class, 'show'])->name('teams.finance');
    Route::post('/teams/{team}/expenses', [FinanceController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/{expense}/download-receipt', [FinanceController::class, 'downloadReceipt'])->name('expenses.downloadReceipt');
    Route::patch('/expenses/{expense}/status', [FinanceController::class, 'updateStatus'])->name('expenses.updateStatus');
    Route::delete('/expenses/{expense}', [FinanceController::class, 'destroy'])->name('expenses.destroy');
    Route::patch('/teams/{team}/budget', [FinanceController::class, 'updateBudget'])->name('teams.updateBudget');
});