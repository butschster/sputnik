<?php

Route::middleware('auth')->group(function () {

    Route::middleware('has-subscription')->group(function () {

        //...

    });
});
