<?php

namespace App\Console\Commands;

use App\Models\YlfGoods;
use App\Models\YlfOrder;
use App\Models\YlfOrderGoods;
use App\Models\YlfUser;
use App\Models\YlfUserAddress;
use Faker\Factory as Factory;
use Faker\Generator as Faker;
use Illuminate\Console\Command;

class ImportOrder extends Command
{
    protected $goods_ids = [];
    protected $signature = 'importorder';

    protected $description = '';
    protected $cache_goods = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $faker = Factory::create('zh_CN');
        // TODO
        set_time_limit(0);
        $this->totalPrice();
        return;
        $time = 150;
        $num = 0;
        for ($j = 0; $j < $time; ++$j) {
            for ($i = 0; $i < $time; ++$i) {
                $num++;
                dump('开始生成订单数据：' . $num);
                $this->mockOneOrder();
                dump('--完成');
            }
            dump('完成一次');
            $this->totalPrice();
            sleep(1);
        }
        $this->totalPrice();
        //dump($u->toJson());
        //echo $faker->ipv4;
    }

    public function totalPrice()
    {
        $result = YlfOrder::where(['pay_status' => 2])->sum('goods_amount');
        dump('总交易额为；' . $result);
    }

    public function mockOneOrder()
    {
        $user = $this->createUser();
        $address = $this->createUserAddress($user);
        $goods = $this->createGoods($user);
        $order = $this->createOrder($user, $address, $goods);
        $goods->each(function ($good) use ($order) {
            $good->order_id = $order->order_id;
            $good->save();
        });
    }

    public function createUser($phone = null, $reg_time = null, $nick_name = '')
    {
        return YlfUser::MockUser($phone, $reg_time, $nick_name);
    }

    public function createUserAddress($user)
    {
        return YlfUserAddress::MockAddress($user);
    }

    public function createGoods(YlfUser $user)
    {
        $order_goods = collect([]);
        if (empty($this->goods_ids)) {
            if (empty($this->cache_goods)) {
                $this->cache_goods = YlfGoods::where([
                    'is_on_sale' => 1,
                ])->get();
            }
        }

        $good1 = $this->cache_goods->random();
        $order_goods->push(YlfOrderGoods::MockOrderGoods($good1, $user));
        $i = random_int(1, 10);
        $good2 = $this->cache_goods->random();
        if ($i > 8 && $good1->goods_id !== $good2->goods_id) {
            $order_goods->push(YlfOrderGoods::MockOrderGoods($good2, $user));
            $i = random_int(1, 10);
            $good3 = $this->cache_goods->random();
            if ($i > 8 && $good1->goods_id !== $good3->goods_id && $good2->goods_id !== $good3->goods_id) {
                $order_goods->push(YlfOrderGoods::MockOrderGoods($good3, $user));
            }
        }

        return $order_goods;
    }

    public function createOrder(YlfUser $user, YlfUserAddress $address, $goods, $time = null)
    {
        return YlfOrder::MockOrder($user, $address, $goods, $time);
    }
}
