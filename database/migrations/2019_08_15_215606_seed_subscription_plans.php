<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Rennokki\Plans\Models\PlanFeatureModel;
use Rennokki\Plans\Models\PlanModel;

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
        $plan = PlanModel::create([
            'name' => 'Unlimited',
            'description' => 'Free plan for 1 server with unlimited sites and databases.',
            'price' => 30,
            'currency' => 'USD',
            'duration' => 30,
        ]);

        $plan->features()->saveMany([
            new PlanFeatureModel([
                'name' => 'Unlimited servers',
                'code' => 'server.create',
                'description' => '',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Unlimited sites',
                'code' => 'server.site.create',
                'description' => '',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Unlimited databases',
                'code' => 'server.database.create',
                'description' => '',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Unlimited cron jobs',
                'code' => 'server.cron_job.create',
                'description' => '',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Unlimited daemons',
                'code' => 'server.daemon.create',
                'description' => '',
                'type' => 'feature',
            ]),
            new PlanFeatureModel([
                'name' => 'Unlimited Deployments',
                'code' => 'server.deployments',
                'description' => '',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Push to deploy',
                'code' => 'server.deployments.push',
                'description' => '',
                'type' => 'feature',
            ]),
            new PlanFeatureModel([
                'name' => 'Websites monitoring',
                'code' => 'server.site.monitoring',
                'description' => '',
                'type' => 'feature',
            ]),
        ]);
    }

    protected function createArtisanPlan()
    {
        $plan = PlanModel::create([
            'name' => 'Artisan',
            'description' => 'Free plan for 1 server with unlimited sites and databases.',
            'price' => 10,
            'currency' => 'USD',
            'duration' => 30,
        ]);

        $plan->features()->saveMany([
            new PlanFeatureModel([
                'name' => 'Single server',
                'code' => 'server.create',
                'description' => '',
                'type' => 'limit',
                'limit' => 1,
            ]),
            new PlanFeatureModel([
                'name' => 'Unlimited sites',
                'code' => 'server.site.create',
                'description' => '',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Unlimited databases',
                'code' => 'server.database.create',
                'description' => '',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Unlimited cron jobs',
                'code' => 'server.cron_job.create',
                'description' => '',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Unlimited daemons',
                'code' => 'server.daemon.create',
                'description' => '',
                'type' => 'feature',
            ]),
            new PlanFeatureModel([
                'name' => 'Unlimited Deployments',
                'code' => 'server.deployments',
                'description' => '',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Push to deploy',
                'code' => 'server.daemon.create',
                'description' => '',
                'type' => 'feature',
            ]),
        ]);
    }

    protected function createFreePlan(): void
    {
        $plan = PlanModel::create([
            'name' => 'Free',
            'description' => 'Free plan for 1 server and 1 site and 1 database.',
            'price' => 0,
            'currency' => 'USD',
            'duration' => 365 * 100,
        ]);

        $plan->features()->saveMany([
            new PlanFeatureModel([
                'name' => 'Single server',
                'code' => 'server.create',
                'description' => '',
                'type' => 'limit',
                'limit' => 1,
            ]),
            new PlanFeatureModel([
                'name' => 'Single site',
                'code' => 'server.site.create',
                'description' => '',
                'type' => 'limit',
                'limit' => 1,
            ]),
            new PlanFeatureModel([
                'name' => 'Single database',
                'code' => 'server.database.create',
                'description' => '',
                'type' => 'limit',
                'limit' => 1,
            ]),
            new PlanFeatureModel([
                'name' => '3 Cron jobs',
                'code' => 'server.cron_job.create',
                'description' => '',
                'type' => 'limit',
                'limit' => 3,
            ]),
            new PlanFeatureModel([
                'name' => '3 Deployments',
                'code' => 'server.site.deployments',
                'description' => '',
                'type' => 'limit',
                'limit' => 3,
            ]),
        ]);
    }
}
