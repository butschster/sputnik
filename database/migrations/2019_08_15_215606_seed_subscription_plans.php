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
                'name' => 'Server',
                'code' => 'server.create',
                'description' => 'Unlimited servers.',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Site',
                'code' => 'server.site.create',
                'description' => 'Unlimited sites.',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Database',
                'code' => 'server.database.create',
                'description' => 'Unlimited databases.',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Cron jobs',
                'code' => 'server.cron_job.create',
                'description' => 'Unlimited cron jobs.',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Daemons',
                'code' => 'server.daemon.create',
                'description' => 'Unlimited daemons.',
                'type' => 'feature',
            ]),
            new PlanFeatureModel([
                'name' => 'Deployments',
                'code' => 'server.deployments',
                'description' => 'Unlimited Deployments',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Monitoring',
                'code' => 'server.site.monitoring',
                'description' => 'Websites monitoring.',
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
                'name' => 'Server',
                'code' => 'server.create',
                'description' => 'Single server.',
                'type' => 'limit',
                'limit' => 1,
            ]),
            new PlanFeatureModel([
                'name' => 'Site',
                'code' => 'server.site.create',
                'description' => 'Unlimited sites.',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Database',
                'code' => 'server.database.create',
                'description' => 'Unlimited databases.',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Cron jobs',
                'code' => 'server.cron_job.create',
                'description' => 'Unlimited cron jobs.',
                'type' => 'limit',
                'limit' => -1,
            ]),
            new PlanFeatureModel([
                'name' => 'Daemons',
                'code' => 'server.daemon.create',
                'description' => 'Unlimited daemons.',
                'type' => 'feature',
            ]),
            new PlanFeatureModel([
                'name' => 'Deployments',
                'code' => 'server.deployments',
                'description' => 'Unlimited Deployments',
                'type' => 'limit',
                'limit' => -1,
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
                'name' => 'Server',
                'code' => 'server.create',
                'description' => 'Single server.',
                'type' => 'limit',
                'limit' => 1,
            ]),
            new PlanFeatureModel([
                'name' => 'Site',
                'code' => 'server.site.create',
                'description' => 'Single site.',
                'type' => 'limit',
                'limit' => 1,
            ]),
            new PlanFeatureModel([
                'name' => 'Database',
                'code' => 'server.database.create',
                'description' => 'Single database.',
                'type' => 'limit',
                'limit' => 1,
            ]),
            new PlanFeatureModel([
                'name' => 'Cron jobs',
                'code' => 'server.cron_job.create',
                'description' => '3 Cron jobs.',
                'type' => 'limit',
                'limit' => 3,
            ]),
            new PlanFeatureModel([
                'name' => 'Deployments',
                'code' => 'server.site.deployments',
                'description' => '3 Deployments',
                'type' => 'limit',
                'limit' => 5,
            ]),
        ]);
    }
}
