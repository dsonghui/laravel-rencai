<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YlfGoods extends Model
{
    public $timestamps = false;

    protected $table = 'dsc_goods';
    protected $primaryKey = 'good_id';
    protected $guarded = [];
}
