<?php

use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Database\Migrations\Migration;

class SeedUserPermissions extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        $owner = Role::create([
            'name' => 'owner',
            'display_name' => 'Team Owner',
        ]);

        $member = Role::create([
            'name' => 'member',
            'display_name' => 'Team member',
        ]);

        $manageSubscriptions = Permission::create([
            'name' => 'subscriptions.manage',
        ]);

        $teamManage = Permission::create([
            'name' => 'team.manage',
        ]);

        $serverCreate = Permission::create([
            'name' => 'server.create',
        ]);

        $serverDelete = Permission::create([
            'name' => 'server.delete',
        ]);

        $serverManage = Permission::create([
            'name' => 'server.manage',
        ]);

        $owner->attachPermissions([
            $teamManage, $manageSubscriptions, $serverCreate, $serverDelete, $serverManage
        ]);

        $member->attachPermission(
            $serverManage
        );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        //
    }
}
