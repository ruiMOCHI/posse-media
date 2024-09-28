<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Models\Article;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/user', [UserController::class, 'index']);

Route::resource('articles', ArticleController::class)->middleware('auth');

Route::get('/articles', [ArticleController::class, 'index'])->middleware(['auth', 'verified']) //複数設定時は()だけでなく、[]も必要
    ->name('articles.index');

Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');  //nameがviewの編集などで飛ぶリンクと同じ名前

Route::post('/articles/store-draft', [ArticleController::class, 'storeDraft'])->name('articles.storeDraft');

Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');

Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');

Route::delete('/articles/{article}/destroy', [ArticleController::class, 'destroy'])->name('articles.destroy');

//adminのroleがログインした時にadminにリダイレクトさせる
Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth','admin'])->name('admin');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('articles/admin/users/list', [ArticleController::class, 'listAdmins'])->name('articles.admin.users.list');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('articles/admin/users/listUser', [ArticleController::class, 'listAdminsUser'])->name('articles.admin.users.listUser');
});

Route::delete('articles/admin/users/listUser/{user}/destroy', [UserController::class, 'destroyUser'])->name('articles.admin.users.listUser.destroy');

Route::post('/articles/{article}/comments', [ArticleController::class, 'storeComment'])->name('comments.store');

Route::get('/comments/{comment}/edit', [ArticleController::class, 'editComment'])->name('comments.edit');

Route::put('/comments/{comment}', [ArticleController::class, 'updateComment'])->name('comments.update');

Route::delete('/comments/{comment}', [ArticleController::class, 'destroyComment'])->name('comments.destroy');

// Route::get('/admin', [ArticleController::class, 'adminList'])
//     ->middleware(['auth', 'verified', 'admin'])
//     ->name('admin.index');

require __DIR__.'/auth.php';
