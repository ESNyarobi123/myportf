<?php

use App\Http\Controllers\PortfolioController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Portfolio\InquiriesManager;
use App\Livewire\Admin\Portfolio\MediaLibrary;
use App\Livewire\Admin\Portfolio\ProjectsManager;
use App\Livewire\Admin\Portfolio\ServicesManager;
use App\Livewire\Admin\Portfolio\SiteProfileManager;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/projects', 'portfolio.projects')->name('projects');
Route::get('/projects/{project}', [PortfolioController::class, 'showProject'])->name('projects.show');
Route::view('/services', 'portfolio.services')->name('services');
Route::view('/about', 'portfolio.about')->name('about');
Route::view('/contact', 'portfolio.contact')->name('contact');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', Dashboard::class)->name('dashboard');

    Route::livewire('admin/projects', ProjectsManager::class)->name('admin.projects');
    Route::livewire('admin/services', ServicesManager::class)->name('admin.services');
    Route::livewire('admin/site-profile', SiteProfileManager::class)->name('admin.site-profile');
    Route::livewire('admin/inquiries', InquiriesManager::class)->name('admin.inquiries');
    Route::livewire('admin/media', MediaLibrary::class)->name('admin.media');
});

require __DIR__.'/settings.php';
