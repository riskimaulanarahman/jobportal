<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::group(['prefix' => 'api'], function () {
    Route::apiResources([
        'employeedata' => App\Http\Controllers\Module\EmployeedataController::class,
        // 'ecatalog' => App\Http\Controllers\Module\EcatalogController::class,
        // 'purchasinguser' => App\Http\Controllers\Module\PurchasinguserController::class,
        'jobs' => App\Http\Controllers\Module\JobController::class,
    ]);


});
