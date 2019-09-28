<?php

namespace App\Models;

use Faker\Factory as Factory;
use Illuminate\Database\Eloquent\Model;

class YlfOrderGoods extends Model
{
    public $timestamps = false;

    protected $table = 'dsc_order_goods';
    protected $primaryKey = 'rec_id';

    protected $guarded = [];

    public static function MockOrderGoods(YlfGoods $goods, YlfUser $user, $goodNumber = 1)
    {
        $faker = Factory::create('zh_CN');
        // order_id
        $goods = [
            'user_id' => $user->user_id,
            'order_id' => 0,
            'cart_recid' => '',
            'goods_id' => $goods->goods_id,
            'goods_name' => $goods->goods_name,
            'goods_sn' => $goods->goods_sn,
            'product_id' => 0,
            'is_real' => 0,
            'warehouse_id' => 3,
            'area_id' => 30,
            'freight' => 2,
            'tid' => 3,
            'stages_qishu' => -1,
            'is_reality' => 0,
            'is_return' => 0,
            'is_fast' => 0,
            'goods_number' => $goodNumber,
            'send_number' => $goodNumber,
            'goods_attr' => '',
            'parent_id' => 0,
            'goods_price' => $goods->shop_price,
            'market_price' => $goods->shop_price,

            'extension_code' => '',
            'is_gift' => 0,
            'model_attr' => 0,
            'goods_attr_id' => '',
            'ru_id' => 0,
            'shopping_fee' => 0,
            'shipping_fee' => 0,
            'is_distribution' => 0,
            'drp_money' => 0,
            'commission_rate' => 0,
        ];
        return self::create($goods);
    }
}
