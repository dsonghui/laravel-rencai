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

        DB::table('oauth_clients')->insert([
            'name'                   => 'Laravel Personal Access Client',
            'secret'                 => 'Zh4Tbd7Vj5TjvNQHQtXxBQe0ow1K2jHZWFOxzmHk',
            'redirect'               => 'http://localhost',
            'personal_access_client' => 1,
            'password_client'        => 0,
            'revoked'                => 0,
            'created_at'             => now(),
            'updated_at'             => now(),
        ]);


        DB::table('oauth_personal_access_clients')->insert([
            'client_id'                 => 2,
            'created_at'             => now(),
            'updated_at'             => now(),
        ]);

        DB::table('oauth_clients')->insert([
            'name'                   => 'Laravel Password Grant Client',
            'secret'                 => 'TD9vve4lho1jzPIt79nncsjMLtFif8H8RjbAYWaA',
            'redirect'               => 'http://localhost',
            'personal_access_client' => 0,
            'password_client'        => 1,
            'revoked'                => 0,
            'created_at'             => now(),
            'updated_at'             => now(),
        ]);
    }
}
