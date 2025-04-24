<?php

use App\Http\Controllers\NewsController;
use App\Livewire\Admin\NewsContent;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegionController;
use App\Http\Controllers\CountyController;
use App\Livewire\News\WriteNews;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


Route::group(['prefix' => 'region', 'middleware' => 'auth'], function () {
    Route::get('/counties', [RegionController::class,'index'])->name('region.index');
    Route::post('upload/counties',[RegionController::class,'uploadCounties'])->name('upload.counties');
    Route::post('upload/constituencies',[RegionController::class,'uploadConstituencies'])->name('upload.constituencies');
    Route::get('/constituencies/{id}', [RegionController::class,'viewConstituencies'])->name('constituencies.show');
    Route::post('upload/subcounties',[RegionController::class,'uploadSubcounties'])->name('upload.subcounties');
    Route::get('delete/constituency/{id}',[RegionController::class,'deleteConstituency'])->name('delete.constituency');
    Route::get('view/subcounties/{id}',[RegionController::class,'viewSubcounties'])->name('view.subcounties');
    Route::get('delete/subcounty/{id}',[RegionController::class,'deleteSubcounties'])->name('delete.subcounty');
});


Route::group(['prefix' => 'news', 'middleware' => 'auth'], function () {
    // WriteNews
    // Route::get('write-news', [WriteNews::class, 'render'])->name('write.news');
    // Route::post('write-news', [NewsContent::class])->name('write.news.store');
    Route::get('write-news', [NewsController::class, 'writeNews'])->name('write.news');
});

Route::get('/phpinfo', function () {
    phpinfo();
});