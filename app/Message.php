<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * 與模型關聯的資料表
     *
     * @var string
     */
    protected $table = 'message';

    /**
     * 定義主键
     *
     * @var string
     */
    protected $primaryKey = 'flight_id';

    /**
     * 可以被批量賦值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'product_id',
        'message_content',
    ];
}
