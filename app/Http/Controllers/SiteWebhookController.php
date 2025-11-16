<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\AmoAddLeadWithContactJob;
use App\Jobs\SendTelegramNotification;
use Illuminate\Support\Facades\Bus;

class SiteWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|phone:RU',
            'apartment_address' => 'required|string|max:255',
        ]);

        Bus::chain([
            new AmoAddLeadWithContactJob($validated),
            new SendTelegramNotification($validated)
        ])->dispatch();
    }
}
