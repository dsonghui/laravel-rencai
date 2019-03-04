<?php

use App\Company;
use App\User;
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
        $company = Company::create([
            'user_id'   => 0,
            'name'      => '测试企业名称1',
            'shortname' => '测试企业名称1',
        ]);
        $user = User::create(['name' => 'company', 'password' => bcrypt('123456'), 'phone' => '1344446' . rand(1000, 9999)]);
        $user->company()->save($company);
    }

    protected function createTalentUser()
    {
        $talent = \App\Talent::create([
            'user_id' => 0,
            'name'    => '邓先生'
        ]);
        $user = User::create(['name' => 'talent', 'password' => bcrypt('123456'), 'phone' => '1344446' . rand(1000, 9999)]);
        $user->talent()->save($talent);
    }
}
