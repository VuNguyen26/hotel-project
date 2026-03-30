<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'subject',
        'message',
        'source_page',
        'ip_address',
        'user_agent',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}