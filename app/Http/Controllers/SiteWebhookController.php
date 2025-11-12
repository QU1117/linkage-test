<?php

namespace App\Http\Controllers;

use App\Services\EventLogger;
use Illuminate\Http\Request;
use App\Jobs\AmoAddLeadWithContactJob;
use App\Jobs\SendTelegramNotification;

class SiteWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|phone:RU',
            'apartment_address' => 'required|string|max:255',
        ]);

        AmoAddLeadWithContactJob::dispatch();
        SendTelegramNotification::dispatch();
    }
}
