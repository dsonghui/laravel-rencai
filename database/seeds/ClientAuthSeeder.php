<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'name'                   => 'pc Client',
            'secret'                 => 'gRrggAoN60ingBAlPxu5taIidGjjDBUUmHst046L',
            'redirect'               => 'http://localhost',
            'personal_access_client' => 1,
            'password_client'        => 1,
            'revoked'                => 0,
            'created_at'             => now(),
            'updated_at'             => now(),
        ]);
    }
}
