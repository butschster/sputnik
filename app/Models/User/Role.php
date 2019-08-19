<?php

namespace App\Models\User;

use App\Models\Concerns\UsesUuid;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    use UsesUuid;

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];
}
