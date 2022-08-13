<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'id';

    protected $fillable = [
        'image_name',
        'image_path',
        'products_id'
    ];
}
