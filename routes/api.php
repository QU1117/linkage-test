<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteWebhookController;
use App\Http\Middleware\LogPostRequests;

Route::post('/webhook', [SiteWebhookController::class, 'handle'])->middleware(LogPostRequests::class);
