<?php

use App\Models\Subscription\Plan;
use Illuminate\Database\Migrations\Migration;

class SeedSubscriptionPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createFreePlan();
        $this->createArtisanPlan();
        $this->createUnlimitedPlan();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    protected function createUnlimitedPlan()
    {
        $plan = Plan::create([
            'name' => 'unlimited',
            'price' => 30,
            'sort_order' => 3,
            'currency' => 'USD',
        ]);

        $plan->features()->saveMany([
            new Plan\Feature([
                'code' => 'server.create',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.site.create',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.database.create',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.cron_job.create',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.daemon.create',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.deployments.run',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.deployments.push',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.site.monitoring',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'teams',
                'value' => 'Y',
            ]),
        ]);
    }

    protected function createArtisanPlan()
    {
        $plan = Plan::create([
            'name' => 'artisan',
            'price' => 10,
            'sort_order' => 2,
            'currency' => 'USD',
        ]);

        $plan->features()->saveMany([
            new Plan\Feature([
                'code' => 'server.create',
                'value' => 1,
            ]),
            new Plan\Feature([
                'code' => 'server.site.create',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.database.create',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.cron_job.create',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.daemon.create',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.deployments.run',
                'value' => 'Y',
            ]),
            new Plan\Feature([
                'code' => 'server.deployments.push',
                'value' => 'Y',
            ]),
        ]);
    }

    protected function createFreePlan(): void
    {
        $plan = Plan::create([
            'name' => 'free',
            'price' => 0,
            'sort_order' => 1,
            'currency' => 'USD',
        ]);

        $plan->features()->saveMany([
            new Plan\Feature([
                'code' => 'server.create',
                'value' => 1,
            ]),
            new Plan\Feature([
                'code' => 'server.site.create',
                'value' => 1,
            ]),
            new Plan\Feature([
                'code' => 'server.database.create',
                'value' => 1,
            ]),
            new Plan\Feature([
                'code' => 'server.cron_job.create',
                'value' => 3,
            ]),
            new Plan\Feature([
                'code' => 'server.deployments.run',
                'value' => 3,
                'renewable' => true
            ]),
        ]);
    }
}
