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
        $owner = User\Role::where('name', 'owner')->firstOrFail();

        $user = factory(User::class)->create([
            'email' => 'admin@site.com',
            'name' => 'Pavel Buchnev',
        ]);

        /** @var User\Team $team */
        $team = User\Team::create([
            'name' => 'Awesome project',
            'owner_id' => $user->id,
        ]);

        $user->attachRole($owner, $team);

        $plan = Plan::findByName('unlimited');

        $team->subscribeTo($plan);
    }
}
