<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
    protected $fillable = [
        'message_id',
        'product_id',
        'message_content',
    ];
}
