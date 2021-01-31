<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $fillable = [
        'admin_codename', 'password', 'sex', 'status', 'permission'
    ];
}
