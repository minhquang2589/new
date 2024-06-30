<?php

use Illuminate\Support\Facades\Route;
//////// 

Route::group(['prefix' => 'api'], function () {
   require __DIR__ . '/user.php';
   Route::middleware(['admin'])->group(function () {
      require __DIR__ . '/admin.php';
   });
});
Route::view('/{any}', 'app')->where('any', '.*');
