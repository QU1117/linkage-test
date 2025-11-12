<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Services\EventLogger;

class SendTelegramNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Request $request)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => "Новая заявка от клиента " . $this->request->json('name') . ", " .
                "телефон: " . $this->request->json('phone') . ", " .
                "объект: " . $this->request->json('apartment_address'),
        ]);

        EventLogger::log(
            'Telegram',
            'Telegram notification sent'
        );
    }
}
