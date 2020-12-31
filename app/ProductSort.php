<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSort extends Model
{
    protected $table = 'products_sort';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'products_sort_details_id'
    ];
}
