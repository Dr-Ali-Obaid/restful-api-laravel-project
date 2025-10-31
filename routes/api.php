<?php

use App\Http\Controllers\LessonController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\OnceBasicMiddleware;
use App\Models\Lesson;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\LessonTagSeeder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;


Route::post('login', [LoginController::class, 'login']);

Route::group(['prefix' => 'v1'], function () {

    // routes of lesson
    Route::apiResource('lesson', LessonController::class);
    // routes of user
    Route::apiResource('user', UserController::class);

    // routes of tag
    Route::apiResource('tag', TagController::class);

    // routes of relations
    Route::get('/user/{id}/lessons', [RelationController::class, 'userLessons']);

    Route::get('/lesson/{id}/tags', [RelationController::class, 'lessonTags']);

    Route::get('/tag/{id}/lessons', [RelationController::class, 'tagLessons']);



    // routes of some tests
    Route::any('/oldlesson', function () {
        $message = "this is old lesson";
          return response()->json(['message' => $message], 400);
    });

    // Route::redirect('oldlesson', 'lesson');
});
