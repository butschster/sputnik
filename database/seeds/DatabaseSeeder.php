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

        $plan = Plan::where('name', 'unlimited')->first();

        $team->subscriptions()->create([
            'name' => 'main',
            'stripe_id' => null,
            'stripe_status' => 'complete',
            'stripe_plan' => $plan->name,
            'quantity' => 1,
            'trial_ends_at' => null,
            'ends_at' => null,
        ]);

//        factory(\App\Models\Server::class)->times(10)->create([
//            'user_id' => $user->id,
//            'team_id' => $team->id,
//            'status' => 'configured'
//        ]);
    }
}
