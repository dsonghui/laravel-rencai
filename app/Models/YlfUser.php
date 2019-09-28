<?php

namespace App\Models;

use Faker\Factory as Factory;
use Illuminate\Database\Eloquent\Model;

class YlfUser extends Model
{
    public $timestamps = false;

    protected $table = 'dsc_users';
    protected $primaryKey = 'user_id';

    protected $guarded = [];

    public static function MockUser($phone = null, $reg_time = null, $nick_name = '')
    {
        $faker = Factory::create('zh_CN');
        $phone = $phone ?: $faker->phoneNumber;
        $reg_time = $reg_time ?: time() - 3600 * 24 * 365 + random_int(1, 3600 * 24 * 365);
        // user_id
        $user = [
            'aite_id' => '',
            'email' => $faker->email,
            'user_name' => $phone,
            'nick_name' => $nick_name ?: $phone,
            'password' => md5(uniqid()),
            'sex' => random_int(1, 2),
            // 'birthday' => '0000-00-00',
            'pay_points' => 1,
            'rank_points' => 1,
            'address_id' => 0,
            'reg_time' => $reg_time,
            'last_login' => 0, // 'TODO'
//         "last_time": "1000-01-01 00:00:00",
            'last_ip' => $faker->ipv4,
//         "visit_count": 0,
            'mobile_phone' => $phone,
            'is_validated' => 0,
            'user_picture' => '', // 用户头像

            'alias' => '',
            'msn' => 'ylf',
            'qq' => '',
            'office_phone' => '',
            'home_phone' => '',
            'credit_line' => '0.00',
            'passwd_question' => '',
            'passwd_answer' => '',
            'old_user_picture' => '',
            'report_time' => 0,
        ];

        return self::create($user);
    }
}
