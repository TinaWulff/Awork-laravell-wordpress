<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordPressController;

Route::get('/', function () {
    return view('welcome');
});

// Til at "logge ind/gemme credentials" for wordpress-side
Route::get('/wordpress-info', [WordPressController::class, 'showForm']);
Route::post('/wordpress-info', [WordPressController::class, 'saveForm']);

// Dashboard og separate sider
Route::get('/wordpress-dashboard', [WordPressController::class, 'showDashboard']);
Route::get('/upload-images', [WordPressController::class, 'showUploadForm']);
Route::get('/create-page', [WordPressController::class, 'showCreatePageForm']);

// NYE ROUTES til næste trin, hvor vi skal poste til WordPress:
Route::get('/wordpress-post', [WordPressController::class, 'showPostForm']);
Route::post('/wordpress-post', [WordPressController::class, 'sendToWordPress']);
Route::post('/add-new-page', [WordpressController::class, 'addNewPage']);
Route::post('/upload-media', [WordpressController::class, 'uploadMedia']);


//TIL ELEMENTOR integration - med to funktionaliteter
Route::get('/wordpress', [WordpressController::class, 'index'])->name('wordpress.dashboard');
Route::post('/add-to-elementor', [WordpressController::class, 'addToElementorPage'])->name('elementor.add');