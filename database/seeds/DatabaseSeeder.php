<?php

use App\Models\Subscription\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $team = User\Team::create([
            'name' => 'Awesome project',
        ]);

        $owner = User\Role::where('name', 'owner')->firstOrFail();

        $user = factory(User::class)->create([
            'email' => 'admin@site.com',
            'name' => 'Pavel Buchnev',
        ]);

        $user->attachRole($owner, $team);

        $team->subscribeTo(
            Plan::where('name', 'artisan')->first()
        );
    }
}
