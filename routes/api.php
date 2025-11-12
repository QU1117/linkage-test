<?php

use Illuminate\Support\Facades\Route;

Route::post('/webhook', 'SiteWebhookController@handle');
