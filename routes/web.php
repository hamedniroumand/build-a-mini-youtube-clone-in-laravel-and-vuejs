<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\VideoController;
use \App\Http\Controllers\UploadVideoController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('channels', 'ChannelController');
Route::get('videos/{video}', [VideoController::class, "show"]);
Route::put('video/{video}', [VideoController::class, 'updateViews']);
Route::get('videos/{video}/comments', [\App\Http\Controllers\CommentController::class, 'index']);
Route::get('comments/{comment}/replies', [\App\Http\Controllers\CommentController::class, 'show']);
Route::post('comments/{video}', [\App\Http\Controllers\CommentController::class, 'store']);

Route::middleware(["auth"])->group(function () {
    Route::post('channels/{channel}/video', [UploadVideoController::class, 'store']);
    Route::get('channels/{channel}/video', [UploadVideoController::class, 'index'])->name('channel.upload');
    Route::resource('channels/{channel}/subscriptions', 'SubscriptionController')->only(["store", "destroy"]);
    Route::put('/video/{video}/update', [VideoController::class, 'update'])->name('videos.update');
    Route::post("/votes/{entityId}/{type}", [\App\Http\Controllers\VoteController::class, 'vote']);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
