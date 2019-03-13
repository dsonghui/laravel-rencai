<?php

namespace Tests;

use App\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

trait UserLoginAndDBTransactions
{
    public $access_token = '';

    public function setUp()
    {
        parent::setUp();
        DB::beginTransaction();

        $userName = str_random();
        //创建用户
        $result = User::create([
            'name'     => $userName,
            'phone'    => '13' . rand(100000000, 999999999),
            'password' => bcrypt('123456')
        ]);

        $response = $this->json('POST', '/oauth/token', [
            'grant_type'    => 'password',
            'username'      => $userName,
            'password'      => '123456',
            'client_id'     => 1,
            'client_secret' => 'gRrggAoN60ingBAlPxu5taIidGjjDBUUmHst046L',
            'scope'         => '*',
        ]);
        $this->access_token = $response->json()['access_token'];
    }

    public function tearDown()
    {
        DB::rollBack();
    }
}
