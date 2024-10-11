<?php

//Blogs
use App\Actions\Blogs\DeleteBlogAction;
use App\Actions\Blogs\UpdateBlogAction;
use App\Actions\Blogs\GetBlogAction;
use App\Actions\Blogs\StoreBlogAction;
use App\Actions\Blogs\GetBlogListAction;

// Photos
use App\Actions\Photos\GetPhotoAction;
use App\Actions\Photos\DeletePhotoAction;
use App\Actions\Photos\UpdatePhotoAction;
use App\Actions\Photos\StorePhotoAction;
use App\Actions\Photos\GetPhotoListAction;
use App\Actions\Photos\StoreBulkPhotoAction;


// Pages
use App\Actions\Pages\DeletePageAction;
use App\Actions\Pages\UpdatePageAction;
use App\Actions\Pages\StorePageAction;
use App\Actions\Pages\GetPageAction;
use App\Actions\Pages\GetPageListAction;


// Videos
use App\Actions\Videos\GetVideoAction;
use App\Actions\Videos\StoreVideoAction;
use App\Actions\Videos\DeleteVideoAction;
use App\Actions\Videos\UpdateVideoAction;
use App\Actions\Videos\StoreBulkVideoAction;
use App\Actions\Videos\GetVideoListAction;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('Import', ImportExcelAction::class);

Route::group(['prefix'=>'blogs'], function(){
    Route::get('', GetBlogListAction::class);
    Route::get('{id}', GetBlogAction::class);
    Route::put('', StoreBlogAction::class);
    Route::post('{id}', UpdateBlogAction::class);
    Route::delete('{id}', DeleteBlogAction::class);
});

Route::group(['prefix'=>'photos'], function(){
    Route::get('', GetPhotoListAction::class);
    Route::get('{id}', GetPhotoAction::class);
    Route::put('', StorePhotoAction::class);
    Route::put('bulk', StoreBulkPhotoAction::class);
    Route::post('bulkDelete', BulkDeletePhotoAction::class);
    Route::post('{id}', UpdatePhotoAction::class);
    Route::delete('{id}', DeletePhotoAction::class);
});

Route::group(['prefix'=>'videos'], function(){
    Route::get('', GetVideoListAction::class);
    Route::get('{id}', GetVideoAction::class);
    Route::put('', StoreVideoAction::class);
    Route::put('bulk', StoreBulkVideoAction::class);
    Route::post('bulkDelete', BulkDeleteVideoAction::class);
    Route::post('{id}', UpdateVideoAction::class);
    Route::delete('{id}', DeleteVideoAction::class);
});

Route::group(['prefix'=>'pages'], function(){
    Route::get('', GetPageListAction::class);
    Route::get('{id}', GetPageAction::class);
    Route::put('', StorePageAction::class);
    Route::post('{id}', UpdatePageAction::class);
    Route::delete('{id}', DeletePageAction::class);
});

Route::get('sitemap', GenerateSitemapAction::class);
