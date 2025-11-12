<?php

namespace App\Services;

use App\Models\EventLog;

class EventLogger
{
    public static function log(string $type, string $description = null, $data = null): void
    {
        (new EventLog([
            'type' => $type,
            'description' => $description,
            'data' => $data
        ]))->save();
    }
}
