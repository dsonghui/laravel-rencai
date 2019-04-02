<?php

namespace Tests\Feature;

use App\Company;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\UserLoginAndDBTransactions;

class CompanyTest extends TestCase
{

    use UserLoginAndDBTransactions;


    public function testCreateCompany()
    {
        $response = $this->json('POST', '/api/company', [
            'name' => 'AutoTestCompany'
        ], [
            "Authorization" => "Bearer " . $this->access_token
        ]);
        $response->assertStatus(200);

        $result = Company::where('name', 'AutoTestCompany')->first();
        $this->assertNotEmpty($result);

        $result = Company::where('name', 'AutoTestCompany999')->first();
        $this->assertEmpty($result);

    }

    public function testGetCompany()
    {
        $result = Company::first();
        $response = $this->json('Get', '/api/company/' . $result->id, [], [
            "Authorization" => "Bearer " . $this->access_token
        ]);
        $response->assertStatus(200);
        $this->assertEquals($response->json()['id'], $result->id);
    }

    public function testUpdateCompany()
    {
        $result = Company::first();
        $response = $this->json('Put', '/api/company/' . $result->id, [
            'name' => $result->name,
            'shortname' => 'new shortname'
        ], [
            "Authorization" => "Bearer " . $this->access_token
        ]);
        $response->assertStatus(200);
        $result2 = Company::where('id', $result->id)->first();
        $this->assertEquals($result2->shortname, 'new shortname');
        $this->assertEquals($result->name, $result2->name);
    }


    public function testHasOneUser()
    {
        $result = Company::with('user')->first();
        $this->assertIsInt($result->user->id);
    }
}
