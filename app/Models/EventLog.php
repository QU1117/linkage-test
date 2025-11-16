<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    protected $fillable = [
        'type', 'description', 'request_data',
    ];

    protected $casts = [
        'request_data' => 'array',
    ];

    protected $table = 'logs';
}
