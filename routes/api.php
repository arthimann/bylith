<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::resource('services', \App\Http\Controllers\V1\WebServiceController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
});
