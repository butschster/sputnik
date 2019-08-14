<?php

namespace App\Models\Server\Site;

use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use App\Models\Server\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deployment extends Model
{
    use UsesUuid, HasTask;

    /**
     * @var string
     */
    protected $table = 'server_site_deployments';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Link to the site
     *
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'server_site_id');
    }

    /**
     * Link to the initiator user
     *
     * @return BelongsTo
     */
    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
