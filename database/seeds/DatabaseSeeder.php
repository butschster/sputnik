<?php

use Illuminate\Database\Seeder;
use Rennokki\Plans\Models\PlanModel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(\App\Models\User::class)->create([
            'email' => 'admin@site.com',
            'name' => 'Pavel Buchnev',
        ]);

        $user->subscribeTo(
            PlanModel::where('name', 'Artisan')->first()
        );

//        $server = factory(\App\Models\Server::class)->create([
//            'user_id' => $user->id,
//            'name' => 'test',
//            'ip' => '167.71.3.113',
//        ]);
    }
}
