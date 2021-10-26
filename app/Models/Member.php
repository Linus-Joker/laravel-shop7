<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'id';
    protected $fillable = [
        'reg_email',
        'reg_phone',
        'user_name',
        'password'
    ];
}
