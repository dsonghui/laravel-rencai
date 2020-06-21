<?php

namespace App\Models;

use Carbon\Carbon;
use Faker\Factory as Factory;
use Illuminate\Database\Eloquent\Model;

class YlfOrder extends Model
{
    public $timestamps = false;

    protected $table = 'dsc_order_info';
    protected $primaryKey = 'order_id';

    protected $guarded = [];

    public static function MockOrder(YlfUser $user, YlfUserAddress $address, $goods, $time = null)
    {
        $faker = Factory::create('zh_CN');
        $time = $time ?: time() - 3600 * 24 * 365 + random_int(1, 3600 * 24 * 365);
        $ctime = $time + random_int(1, 3600 * 2);
        $ptime = $ctime + random_int(1, 3600 * 2);
        $stime = $ptime + random_int(1, 3600 * 2);

        $goods_price = 0;
        foreach ($goods as $good) {
            $goods_price = $goods_price + $good->goods_price;
        }

        // order_id
        $order = [
            // 'order_id' => 209,
            'main_order_id' => 0,
            'order_sn' => Carbon::create()->timestamp($time)->format('YmdHis') . '' . random_int(10000, 99999), //   20181109163059 55656
            'user_id' => $user->user_id,
            'order_status' => 1,
            'shipping_status' => 2,
            'pay_status' => 2,
            'consignee' => $address->consignee,
            'country' => $address->country,
            'province' => $address->province,
            'city' => $address->city,
            'district' => $address->district,
            'street' => 0,
            'address' => $address->address,
            'zipcode' => '',
            'tel' => '',
            'mobile' => $address->mobile,
            'email' => '',
            'best_time' => '',
            'sign_building' => '',
            'postscript' => '',
            'shipping_id' => '16', // 顺丰
            'shipping_name' => '顺丰速运',
            'shipping_code' => 'sf_express',
            'shipping_type' => 0,
            'pay_id' => 17,
            'pay_name' => '微信支付',
            'how_oos' => '等待所有商品备齐后再发',
            'how_surplus' => '',
            'pack_name' => '',
            'card_name' => '',
            'card_message' => '',
            'inv_payee' => '',
            'inv_content' => '',
            'goods_amount' => $goods_price, // 价格
            'cost_amount' => 0,
            'shipping_fee' => 0,
            'insure_fee' => 0,
            'pay_fee' => 0,
            'pack_fee' => 0,
            'card_fee' => 0,
            'money_paid' => 0,
            'surplus' => 0,
            'integral' => 0,
            'integral_money' => 0,
            'bonus' => 0,
            'order_amount' => $goods_price, // TODO
            'return_amount' => 0,
            'from_ad' => 0,
            'referer' => '本站',
            'add_time' => $time,
            'confirm_time' => $ctime,
            'pay_time' => $ptime,
            'shipping_time' => $stime,
            'confirm_take_time' => 0,
            'auto_delivery_time' => 15,
            'pack_id' => 0,
            'card_id' => 0,
            'bonus_id' => 0,
            'invoice_no' => '200' . random_int(10000, 99999) . random_int(1000, 9999),
            'extension_code' => '',
            'extension_id' => 0,
            'to_buyer' => '',
            'pay_note' => '',
            'agency_id' => 0,
            'inv_type' => '',
            'tax' => '0.00',
            'is_separate' => 0,
            'parent_id' => 0,
            'discount' => '0.00',
            'discount_all' => '0.00',
            'is_delete' => 0,
            'is_settlement' => 0,
            'sign_time' => null,
            'is_single' => 0,
            'point_id' => '0',
            'shipping_dateStr' => '',
            'supplier_id' => 0,
            'froms' => 'pc',
            'coupons' => '0.00',
            'uc_id' => 1, // 标记
            'is_zc_order' => 0,
            'zc_goods_id' => 0,
            'is_frozen' => 0,
            'drp_is_separate' => 0,
            'team_id' => 0,
            'team_parent_id' => 0,
            'team_user_id' => 0,
            'team_price' => '0.00',
            'chargeoff_status' => 0,
            'invoice_type' => 0,
            'vat_id' => 0,
            'tax_id' => '',
            'is_update_sale' => 0,
        ];

        return self::create($order);
    }
}
