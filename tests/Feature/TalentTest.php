<?php

namespace Tests\Feature;

use App\Talent;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\UserLoginAndDBTransactions;

class TalentTest extends TestCase
{

    use UserLoginAndDBTransactions;


    public function testCreateTalent()
    {
        $response = $this->json('POST', '/api/talent', [
            'name' => 'AutoTestTalent'
        ], [
            "Authorization" => "Bearer " . $this->access_token
        ]);
        $response->assertStatus(200);

        $result = Talent::where('name', 'AutoTestTalent')->first();
        $this->assertNotEmpty($result);

        $result = Talent::where('name', 'AutoTestTalent999')->first();
        $this->assertEmpty($result);

    }

    public function testGetTalent()
    {
        $result = Talent::first();
        $response = $this->json('Get', '/api/talent/' . $result->id, [], [
            "Authorization" => "Bearer " . $this->access_token
        ]);
        $response->assertStatus(200);
        $this->assertEquals($response->json()['id'], $result->id);
    }

    public function testUpdateTalent()
    {
        $result = Talent::first();
        $response = $this->json('Put', '/api/talent/' . $result->id, [
            'name' => $result->name,
            'birthday' => Carbon::now()->toDateString()
        ], [
            "Authorization" => "Bearer " . $this->access_token
        ]);
        $response->assertStatus(200);
        $result2 = Talent::where('id', $result->id)->first();
        $this->assertEquals($result2->birthday, Carbon::now()->toDateString());
        $this->assertEquals($result->name, $result2->name);
    }


    public function testHasOneUser()
    {
        $result = Talent::with('user')->first();
        $this->assertIsInt($result->user->id);
    }

}
