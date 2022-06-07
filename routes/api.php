<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth/register',[\App\Http\Controllers\AuthController::class,'register']);
Route::get('/auth/login',[\App\Http\Controllers\AuthController::class,'login']);

Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::apiResource('articles',\App\Http\Controllers\API\ArticleController::class);
    Route::apiResource('users',\App\Http\Controllers\API\UserController::class);
    Route::delete('/articles/{article}/deleteImage/{articleImage}',[\App\Http\Controllers\API\ArticleImageController::class,'destroy']);
    Route::post('/articles/{article}/deleteImage/{articleImage}',[\App\Http\Controllers\API\ArticleImageController::class,'update']);
    Route::post('/articles/{article}',[\App\Http\Controllers\API\ArticleImageController::class,'store']);

});

