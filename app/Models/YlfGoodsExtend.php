<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YlfGoodsExtend extends Model
{
    public $timestamps = false;

    protected $table = 'dsc_goods_extend';
    protected $primaryKey = 'extend_id';
    protected $guarded = [];
}
