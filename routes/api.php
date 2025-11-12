<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteWebhookController;

Route::post('/webhook', [SiteWebhookController::class, 'handle']);
