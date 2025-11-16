<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Services\EventLogger;

class SendTelegramNotification implements ShouldQueue
{
    use Queueable;

    private string $userName;
    private string $userPhone;
    private string $apartment_address;

    /**
     * Create a new job instance.
     */
    public function __construct(array $userData)
    {
        $this->userName = $userData['name'];
        $this->userPhone = $userData['phone'];
        $this->apartment_address = $userData['apartment_address'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $chatId = config('telegram.bots.mybot.chat_id');

        if (!$chatId) {
            EventLogger::log('Telegram Notification Fail',
                'Error in SendTelegramNotification Job: chat_id is empty');
            return;
        }

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "Новая заявка от клиента {$this->userName}, "
                . "телефон: {$this->userPhone}, "
                . "объект: {$this->apartment_address}"
        ]);
    }
}
