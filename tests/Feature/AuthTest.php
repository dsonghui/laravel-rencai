<?php

namespace Tests\Feature;

use App\User;
use Tests\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * Test registration
     */
    public function testRegister()
    {
        //创建测试用户数据
        $data = [
            'name'                  => 'CompanyTest',
            'phone'                 => '13450166666',
            'password'              => '123456',
            'password_confirmation' => '123456',
        ];
        //发送 post 请求
        $response = $this->json('POST', '/api/auth/register', $data);
        //判断是否发送成功
        $response->assertStatus(200);
        //接收我们得到的 token
        $this->assertArrayHasKey('token', $response->json());
    }

    /**
     * @test
     * Test login
     */
    public function testLogin()
    {
        //创建用户
        User::create([
            'name'     => 'UserTest',
            'phone'    => '123123123',
            'password' => bcrypt('123456')
        ]);
        //模拟登陆
        $response = $this->json('POST', '/oauth/token', [
            'grant_type'    => 'password',
            'username'      => 'UserTest',
            'password'      => '123456',
            'client_id'     => 1,
            'client_secret' => 'gRrggAoN60ingBAlPxu5taIidGjjDBUUmHst046L',
            'scope'         => '*',
        ]);
        //判断是否登录成功并且收到了 token
        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $response->json());
        //删除用户
    }
}
