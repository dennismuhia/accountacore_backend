<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RoleController;
use App\Livewire\Admin\NewsContent;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegionController;
use App\Http\Controllers\CountyController;
use App\Livewire\News\WriteNews;

Route::view('/', 'welcome');



Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::post('user/login', [AuthController::class,'login'])->name('user.login');
Route::post('user/logout', [AuthController::class, 'logout'])->name('user.logout');

Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->middleware('guest')
    ->name('login');

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


Route::get('dashboard', [NewsController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::group(['prefix' => 'news', 'middleware' => 'auth'], function () {
    Route::get('delete-news/{id}',[NewsController::class,'deleteNews'])->name('delete.news');
    Route::get('edit-news/{id}',[NewsController::class,'editNews'])->name('edit.news');

    Route::get('write-news', [NewsController::class, 'writeNews'])->name('write.news');

});

// Route::get('/roles', function () {
//     return view('users.role.list');
// });
Route::get('/phpinfo', function () {
    phpinfo();
});

Route::resource('roles', RoleController::class)->middleware(['auth', 'verified']);