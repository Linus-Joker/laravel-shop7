<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name', 'description', 'price',
    ];
}
