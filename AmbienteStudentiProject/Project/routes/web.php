<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ProposalsController;
use App\Http\Controllers\NotificationsController;

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

Route::get('/', [PagesController::class, 'auth'])->name('auth');
Route::get('/google/login', [GoogleController::class, 'loginWithGoogle'])->name('google.login');
Route::any('/google/callback', [GoogleController::class, 'callBackFromGoogle'])->name('google.callback');

Route::group(['middleware' => ['auth']], function() {

    //Save Credentials Route
    Route::get('/saveCred', [PagesController::class, 'saveCred'])->name('saveCredPage');
    Route::get('/saveCred/{remember}', [GoogleController::class, 'saveCred'])->name('saveCred');
        
    //Logged in 
    Route::post('/user', [UsersController::class, 'firstLogin'])->name('first.login');
    
    //Profile Routes
    Route::get('/profile/{id}', [PagesController::class, 'profile'])->name('profile');
    Route::get('/logout', [GoogleController::class, 'logout'])->name('logout');

    //News page
    Route::get('/news', [PagesController::class, 'news'])->name('news');

    //Documentation and Rules
    Route::get('/documentation', [PagesController::class, 'documentation'])->name('documentation');

    //reportError
    Route::post('/report/Error', [EmailController::class, 'reportError'])->name('report.error');
    
    //Back ??
    Route::get('/back', [PagesController::class, 'back'])->name('back');

    Route::group(['middleware' => ['student']], function() {

        //Student main page
        Route::get('/main', [PagesController::class, 'main'])->name('main');
        
        //Proposal Routes
        Route::post('/proposal', [ProposalsController::class, 'store'])->name('proposal.store');
        Route::delete('/proposal', [ProposalsController::class, 'destroyMine'])->name('proposal.delete.mine');
        Route::put('/proposal', [ProposalsController::class, 'edit'])->name('proposal.edit');

        //Comments Routes
        Route::get('/comments/{id}', [CommentsController::class, 'showComments'])->name('showComments');
        Route::get('/relatedComment/{comment_id}', [CommentsController::class, 'showOneComment'])->name('showOneComment');
        Route::get('/relatedComments/{comment_id}', [CommentsController::class, 'relComments'])->name('relatedComments');
        Route::any('/comments', [CommentsController::class, 'store'])->name('comment.store');
        Route::delete('/comments/cancel/{comment_id}', [CommentsController::class, 'cancel'])->name('comment.cancel');

        Route::any('/like/{id}/{type}', [LikesController::class, 'like'])->name('like');

        Route::post('/notifications', [NotificationsController::class, 'seen'])->name('notifications.seen');

        Route::post('/setSession', [SessionController::class, 'set'])->name('set.session');
    });
    
    Route::group(['middleware' => ['moderator']], function() {

        //Moderator main page
        Route::get('/admin', [PagesController::class, 'admin'])->name('admin');

        //Comments
        Route::get('/retrieveAllComments/{proposal_id}', [CommentsController::class, 'retrieveAllComments'])->name('retrieveAllComments');

        //Report 
        Route::post('/report', [ReportsController::class, 'store'])->name('report.store');

        //News routes
        Route::post('/news', [NewsController::class, 'store'])->name('news.store');
        Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.delete');
        
        //Proposal Routes
        Route::group(['middleware' => ['principal']], function() {

            //Change level of a user
            Route::get('/user/level/{id}/{level}', [UsersController::class, 'changeLevel'])->name('user.level.change');
            Route::post('/user/store', [UsersController::class, 'store'])->name('user.store');
            Route::delete('/proposal/{id}', [ProposalsController::class, 'destroy'])->name('proposal.delete');
            Route::delete('/comments/delete/{comment_id}', [CommentsController::class, 'destroy'])->name('comment.delete');
            Route::delete('/user/delete/{id}', [UsersController::class, 'destroy'])->name('user.delete');

        });

        //Flag (((((((())))))))
        Route::get('/proposal/flag/{proposal_id}', [ProposalsController::class, 'flag'])->name('flag.proposal');
    });
});

Route::group(['middleware' => ['configFunction']], function() {

});

Route::get('/testcron', [PagesController::class, 'testcron'])->name('test.cron');
Route::get('/changeWeek/{week}', [PagesController::class, 'changeWeek'])->name('change.week');
Route::get('/secWeekDeleting', [PagesController::class, 'secWeekDeleting'])->name('sec.delete.proposals');
Route::get('/fourthWeekDeleting', [PagesController::class, 'fourthWeekDeleting'])->name('fourth.delete.proposals');

Route::get('/errorPage/{error}', [PagesController::class, 'errorPage'])->name('errorPage');
Route::get('/provaPage', [PagesController::class, 'provaPage'])->name('provaPage');

