<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

///////////////////////
Route::get('/tweets', [App\Http\Controllers\Tweets::class, 'tweets'])->name('tweets.tweets');

Route::post('/searchTweets', [App\Http\Controllers\Tweets::class, 'searchTweets'])->name('tweets.searchTweets');

/////////////////////////

// Wyswietlenie wszystkich słów
Route::get('/keywords', [App\Http\Controllers\KeywordsController::class, 'getAllKeywords'])->name('keyword.getAllKeywords');

// Tworzenie nowego słowa - formularz
Route::get('/keywords/creatingForm', [App\Http\Controllers\KeywordsController::class, 'createKeywordForm'])->name('keyword.createKeywordForm');

// Tworzenie nowego słowa - akcja zwraca liste keywordów
Route::post('/keywords/create', [App\Http\Controllers\KeywordsController::class, 'createKeyword'])->name('keyword.createKeyword');

// Usuwanie keyworda
Route::post('/removeKeyword/{i}', [App\Http\Controllers\KeywordsController::class, 'removeKeyword'])->name('keyword.removeKeyword');


// Wyswietlenie tweeta zwiazanego z danym keywordem
Route::post('/searchTweetsByKeyword/{i}', [App\Http\Controllers\KeywordsController::class, 'searchTweetsByKeyword'])->name('keyword.searchTweetsByKeyword');

// Zmiana stanu tweeta na nieinteresujący
Route::post('/tweets/{i}/setTweetToNotInteresting/{j}', [App\Http\Controllers\KeywordsController::class, 'setToNotInteresting'])->name('keyword.setToNotInteresting');

// Zmiana stanu tweeta na interesujący
Route::post('/tweets/{i}/setTweetToInteresting/{j}', [App\Http\Controllers\KeywordsController::class, 'setToInteresting'])->name('keyword.setToInteresting');

/////////////////////////
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('profile.show');

