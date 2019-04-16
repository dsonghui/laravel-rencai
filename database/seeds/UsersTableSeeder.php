<?php

use App\Company;
use App\User;
use App\Job;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $this->createCompanyUser();
        $this->createTalentUser();
    }

    protected function createCompanyUser()
    {
        factory(User::class, 10)->create()->each(function ($user) {
            $user->is_company = 1;
            $user->save();
            $user->company()->save(factory(Company::class)->make());
            $job = factory(Job::class)->make();
            $job->company_id = $user->company->id;
            $user->company->jobs()->save($job);
        });

    }

    protected function createTalentUser()
    {
        factory(User::class, 10)->create()->each(function ($user) {
            $user->talent()->save(factory(\App\Talent::class)->make());
            // 增加简历;
            //$job = factory(Job::class)->make();
            //$job->company_id = $user->company->id;
            //$user->company->jobs()->save($job);
        });
    }
}
