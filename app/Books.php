<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    //book 為product 資料表因為一開始的想法只有書本產品
    protected $table = 'products';
    protected $fillable = [
        'name', 'description', 'price', 'products_sort_id'
    ];

    // protected $with = ['sort'];
    // public function sort()
    // {
    //     return $this->hasOne('App\ProductSort', 'id', 'products_sort_id');
    // }

    protected $with = ['productImage'];
    public function productImage()
    {
        // return $this->hasOne('App\Phone', 'foreign_key', 'local_key');
        return $this->hasOne('App\ProductImage', 'products_id', 'id');
    }
}
