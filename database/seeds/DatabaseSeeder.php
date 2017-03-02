<?php

use App\Models\HostServer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User Model
        DB::table('users')->delete();
        factory(User::class, 10)->create();
    
        // HostServer Model
        DB::table('host_servers')->delete();
        factory(HostServer::class, 5)->create();
    }
}
