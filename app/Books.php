<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name', 'description', 'price', 'products_sort_id'
    ];
    protected $with = ['sort'];

    public function sort()
    {
        return $this->hasOne('App\ProductSort', 'id', 'products_sort_id');
    }
}
