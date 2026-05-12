<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::get('/health', fn () => response()->json([
    'ok' => true,
    'time' => now()->toIso8601String(),
]))->name('health');

// CMS pages — keep this LAST so it doesn't shadow other routes.
Route::get('/{page:slug}', [PageController::class, 'show'])
    ->where('page', '^(?!admin|livewire|api|sitemap\.xml|health|projects).*')
    ->name('pages.show');
