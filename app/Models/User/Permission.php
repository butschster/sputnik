<?php

namespace App\Models\User;

use App\Models\Concerns\UsesUuid;
use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    use UsesUuid;

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];
}
