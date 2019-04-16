<?php

namespace Tests\Feature;

use App\Company;
use App\Job;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyTest extends TestCase
{

    public $access_token = '';

    use DatabaseTransactions, WithFaker;

    protected function createCompanyToken()
    {
        if (!$this->access_token) {
            $company = Company::first();
            $this->access_token = $company->user->createToken('Created register Token')->accessToken;
        }
        return $this->access_token;
    }

    public function testCreateCompany()
    {
        $title = $this->faker->title;
        $response = $this->json('POST', '/api/job', [
            'company_id'  => $title,
            'title'       => $title,
            'desc'        => $this->faker->title,
            'position'    => '文员',
            'job_address' => $this->faker->address,
            'job_salary'  => '面议',
        ], [
            "Authorization" => "Bearer " . $this->createCompanyToken()
        ]);
        $response->assertStatus(200);

        $job = Job::where('title', $title)->first();
        $this->assertNotEmpty($job);


    }

    public function testGetJob()
    {
        $job = Job::first();
        $response = $this->json('Get', '/api/job/' . $job->id, [], [
            // "Authorization" => "Bearer " . $this->createCompanyToken()
        ]);
        $response->assertStatus(200);
        $this->assertEquals($response->json()['id'], $job->id);
    }

    public function testUpdateCompany()
    {

        $title = $this->faker->title;
        $job = Job::first();
        $response = $this->json('Put', '/api/job/' . $job->id, [
            'title' => $title
        ], [
            "Authorization" => "Bearer " . $this->createCompanyToken()
        ]);
        $response->assertStatus(200);

        $title = $this->faker->title;
        $job = Job::first();
        $response = $this->json('Put', '/api/job/' . $job->id, [
            'title'      => $title,
            'company_id' => 2
        ], [
            "Authorization" => "Bearer " . $this->createCompanyToken()
        ]);
        $response->assertStatus(400);
    }

}
