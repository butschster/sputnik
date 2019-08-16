<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Rinvex\Subscriptions\Models\Plan;
use Rinvex\Subscriptions\Models\PlanFeature;

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
            'name' => 'Unlimited',
            'description' => 'Free plan for 1 server with unlimited sites and databases.',
            'price' => 30,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 5,
            'trial_interval' => 'day',
            'sort_order' => 3,
            'currency' => 'USD',
        ]);

        $plan->features()->saveMany([
            new PlanFeature([
                'name' => 'server_create',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_site_create',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_database_create',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_cron_job_create',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_daemon_create',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_deployments',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_deployments_push',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_site_monitoring',
                'value' => 'Y',
            ]),
        ]);
    }

    protected function createArtisanPlan()
    {
        $plan = Plan::create([
            'name' => 'Artisan',
            'description' => 'Free plan for 1 server with unlimited sites and databases.',
            'price' => 10,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 5,
            'trial_interval' => 'day',
            'sort_order' => 3,
            'currency' => 'USD',
        ]);

        $plan->features()->saveMany([
            new PlanFeature([
                'name' => 'server_create',
                'value' => 1,
            ]),
            new PlanFeature([
                'name' => 'server_site_create',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_database_create',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_cron_job_create',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_daemon_create',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_deployments',
                'value' => 'Y',
            ]),
            new PlanFeature([
                'name' => 'server_daemon_create',
                'value' => 'Y',
            ]),
        ]);
    }

    protected function createFreePlan(): void
    {
        $plan = Plan::create([
            'name' => 'Free',
            'description' => 'Free plan for 1 server and 1 site and 1 database.',
            'price' => 0,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_interval' => 'day',
            'sort_order' => 3,
            'currency' => 'USD',
        ]);

        $plan->features()->saveMany([
            new PlanFeature([
                'name' => 'server_create',
                'value' => 1,
            ]),
            new PlanFeature([
                'name' => 'server_site_create',
                'value' => 1,
            ]),
            new PlanFeature([
                'name' => 'server_database_create',
                'value' => 1,
            ]),
            new PlanFeature([
                'name' => 'server_cron_job_create',
                'value' => 3,
            ]),
            new PlanFeature([
                'name' => 'server_site_deployments',
                'value' => 3,
            ]),
        ]);
    }
}
