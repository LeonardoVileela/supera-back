<?php

use Illuminate\Support\Facades\Route;

Route::prefix('maintenances')->group(function () {
       Route::get('/', function(){
           return 'test';
       });
});
