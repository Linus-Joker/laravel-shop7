<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetalis extends Model
{
    protected $table = 'products_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
}
