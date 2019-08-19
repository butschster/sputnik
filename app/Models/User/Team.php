<?php

namespace App\Models\User;

use App\Models\Concerns\HasSubscriptions;
use App\Models\Concerns\UsesUuid;
use Laratrust\Models\LaratrustTeam;

class Team extends LaratrustTeam
{
    use UsesUuid,
        HasSubscriptions;

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];
}
