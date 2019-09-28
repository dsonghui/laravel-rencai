<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YlfRegion extends Model
{
    public $timestamps = false;

    protected $table = 'dsc_region';
    protected $primaryKey = 'region_id';
    protected $guarded = [];

    public static $citys = [];
    public static $citys2 = [];

    public static function getCitys($parent_id)
    {
        if (empty(self::$citys)) {
            $cs = self::where(['region_type' => 2, 'parent_id' => $parent_id])->get();
            self::$citys = $cs->toArray();
        }
        return self::$citys;
    }

    public static function getCitys2($parent_id)
    {
        if (empty(self::$citys[$parent_id])) {
            $cs = self::where(['region_type' => 3, 'parent_id' => $parent_id])->get();
            self::$citys2[$parent_id] = $cs->toArray();
        }
        return self::$citys2[$parent_id];
    }
}
